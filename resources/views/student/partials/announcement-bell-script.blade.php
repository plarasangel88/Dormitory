<script>
document.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector('[data-student-notifications-button]');
    const dropdown = document.querySelector('[data-student-notifications-dropdown]');
    const badge = document.querySelector('[data-student-notifications-badge]');
    const list = document.querySelector('[data-student-notifications-list]');
    const readAllButton = document.querySelector('[data-student-notifications-read-all]');
    if (!button || !dropdown || !badge || !list || !readAllButton) return;
    const sidebar = document.getElementById('studentSidebar') || document.getElementById('sidebar');
    const sidebarToggle = document.querySelector('[data-student-sidebar-toggle]');
    const sidebarOverlay = document.querySelector('[data-student-sidebar-overlay]');

    const userId = @json(auth()->id());
    const dashboardUrl = @json(route('dashboard'));
    const storagePrefix = 'dormPortalAnnouncements:' + userId + ':';
    const readKey = storagePrefix + 'readIds';
    const lastSeenKey = storagePrefix + 'lastSeenId';
    let announcements = [];
    let loading = false;

    function readIds() {
        try { return JSON.parse(localStorage.getItem(readKey) || '[]').map(String); }
        catch (error) { return []; }
    }

    function render() {
        const read = readIds();
        const unread = announcements.filter(item => !read.includes(String(item.id)));
        badge.hidden = unread.length === 0;
        badge.textContent = unread.length > 99 ? '99+' : String(unread.length);
        list.replaceChildren();

        if (!announcements.length) {
            const empty = document.createElement('div');
            empty.className = 'empty-notification';
            empty.textContent = 'No announcements right now.';
            list.appendChild(empty);
            return;
        }

        announcements.forEach(item => {
            const row = document.createElement('div');
            row.className = 'notification-item' + (read.includes(String(item.id)) ? '' : ' unread');
            const icon = document.createElement('span');
            icon.className = 'notification-icon';
            const iconElement = document.createElement('i');
            iconElement.className = 'fa-solid ' + (item.is_pinned ? 'fa-thumbtack' : 'fa-bullhorn');
            icon.appendChild(iconElement);
            const content = document.createElement('div');
            content.className = 'notification-text';
            const title = document.createElement('h4');
            title.textContent = item.title || 'Announcement';
            const body = document.createElement('p');
            body.textContent = item.body || '';
            const time = document.createElement('span');
            time.className = 'notification-time';
            time.textContent = 'Posted ' + (item.created_human || 'recently');
            content.append(title, body, time);
            row.append(icon, content);
            row.addEventListener('click', () => {
                localStorage.setItem(readKey, JSON.stringify([...new Set([...readIds(), String(item.id)])]));
                render();
            });
            list.appendChild(row);
        });
    }

    async function refresh() {
        if (loading) return;
        loading = true;
        try {
            const response = await fetch(dashboardUrl, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' },
                credentials: 'same-origin',
                cache: 'no-store'
            });
            if (!response.ok) throw new Error('Announcement request failed.');
            const html = await response.text();
            const documentFromResponse = new DOMParser().parseFromString(html, 'text/html');
            const dataElement = documentFromResponse.getElementById('announcementData');
            if (!dataElement) throw new Error('Announcement data is missing.');
            const next = JSON.parse(dataElement.textContent || '[]');
            if (!Array.isArray(next)) return;
            announcements = next;
            if (localStorage.getItem(lastSeenKey) === null && announcements.length) {
                localStorage.setItem(readKey, JSON.stringify(announcements.map(item => String(item.id))));
                localStorage.setItem(lastSeenKey, String(announcements[0].id));
            }
            render();
        } catch (error) {
            console.warn('Could not refresh student announcements:', error);
        } finally {
            loading = false;
        }
    }

    button.addEventListener('click', event => {
        event.stopPropagation();
        const isOpen = dropdown.classList.toggle('open');
        button.setAttribute('aria-expanded', String(isOpen));
        if (isOpen) refresh();
    });
    dropdown.addEventListener('click', event => event.stopPropagation());
    document.addEventListener('click', () => {
        dropdown.classList.remove('open');
        button.setAttribute('aria-expanded', 'false');
    });
    readAllButton.addEventListener('click', () => {
        localStorage.setItem(readKey, JSON.stringify(announcements.map(item => String(item.id))));
        if (announcements.length) localStorage.setItem(lastSeenKey, String(announcements[0].id));
        render();
    });

    function closeSidebar() {
        sidebar?.classList.remove('show');
        sidebarOverlay?.classList.remove('show');
    }
    sidebarToggle?.addEventListener('click', () => {
        sidebar?.classList.toggle('show');
        sidebarOverlay?.classList.toggle('show');
    });
    sidebarOverlay?.addEventListener('click', closeSidebar);
    sidebar?.querySelectorAll('a').forEach(link => link.addEventListener('click', closeSidebar));

    refresh();
    window.setInterval(refresh, 30000);
});
</script>
