<script>
document.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector('[data-student-notifications-button]');
    const dropdown = document.querySelector('[data-student-notifications-dropdown]');
    const badge = document.querySelector('[data-student-notifications-badge]');
    const list = document.querySelector('[data-student-notifications-list]');
    const readAllButton = document.querySelector('[data-student-notifications-read-all]');
    if (!button || !dropdown || !badge || !list || !readAllButton) return;

    const userId = @json(auth()->id());
    const dashboardUrl = @json(route('dashboard'));
    const feedUrl = @json(route('notifications.feed'));
    const readAllUrl = @json(route('notifications.read-all'));
    const readUrl = @json(route('notifications.read', ['notification' => '__notification__']));
    const csrfToken = @json(csrf_token());
    const storagePrefix = 'dormPortalAnnouncements:' + userId + ':';
    const readKey = storagePrefix + 'readIds';
    const lastSeenKey = storagePrefix + 'lastSeenId';
    let announcements = [];
    let activityNotifications = [];
    let activityUnreadCount = 0;
    let loading = false;

    function readIds() {
        try { return JSON.parse(localStorage.getItem(readKey) || '[]').map(String); }
        catch (error) { return []; }
    }

    function makeElement(tag, className, text) {
        const element = document.createElement(tag);
        if (className) element.className = className;
        if (text !== undefined && text !== null) element.textContent = text;
        return element;
    }

    function render() {
        const read = readIds();
        const unreadAnnouncementCount = announcements.filter(item => !read.includes(String(item.id))).length;
        const totalUnread = unreadAnnouncementCount + activityUnreadCount;
        badge.hidden = totalUnread === 0;
        badge.textContent = totalUnread > 99 ? '99+' : String(totalUnread);
        list.replaceChildren();

        const items = [
            ...announcements.map(item => ({ ...item, notificationKind: 'announcement' })),
            ...activityNotifications.map(item => ({ ...item, notificationKind: 'activity' })),
        ].sort((first, second) => new Date(second.created_at || 0) - new Date(first.created_at || 0));

        if (!items.length) {
            list.appendChild(makeElement('div', 'empty-notification', 'No notifications right now.'));
            return;
        }

        items.forEach(item => {
            const isAnnouncement = item.notificationKind === 'announcement';
            const isUnread = isAnnouncement
                ? !read.includes(String(item.id))
                : !item.is_read;
            const row = makeElement(
                isAnnouncement ? 'div' : 'a',
                'notification-item' + (isUnread ? ' unread' : '') + (isAnnouncement ? '' : ' notification-link')
            );
            const iconWrap = makeElement('span', 'notification-icon');
            const icon = makeElement('i', 'fa-solid ' + (isAnnouncement
                ? (item.is_pinned ? 'fa-thumbtack' : 'fa-bullhorn')
                : (item.icon || 'fa-bell')));
            iconWrap.appendChild(icon);

            const content = makeElement('span', 'notification-text');
            const title = makeElement('h4', '', isAnnouncement ? (item.title || 'Announcement') : (item.title || 'Dorm Portal update'));
            const message = makeElement('p', '', isAnnouncement ? (item.body || '') : (item.message || ''));
            const time = makeElement('small', 'notification-time', isAnnouncement
                ? 'Posted ' + (item.created_human || 'recently')
                : (item.created_human || 'Recently'));
            content.append(title, message, time);
            row.append(iconWrap, content);

            if (isAnnouncement) {
                row.addEventListener('click', () => {
                    localStorage.setItem(readKey, JSON.stringify([...new Set([...readIds(), String(item.id)])]));
                    render();
                });
            } else {
                const destination = new URL(item.url || '/', window.location.origin);
                row.href = destination.origin === window.location.origin ? destination.href : dashboardUrl;
                row.addEventListener('click', async event => {
                    event.preventDefault();
                    try {
                        await fetch(readUrl.replace('__notification__', encodeURIComponent(item.id)), {
                            method: 'PATCH',
                            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                            credentials: 'same-origin'
                        });
                    } finally {
                        window.location.assign(row.href);
                    }
                });
            }

            list.appendChild(row);
        });
    }

    async function refresh() {
        if (loading) return;
        loading = true;
        const [announcementResult, notificationResult] = await Promise.allSettled([
            fetch(dashboardUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }, credentials: 'same-origin', cache: 'no-store' }),
            fetch(feedUrl, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin', cache: 'no-store' }),
        ]);

        try {
            if (announcementResult.status === 'fulfilled' && announcementResult.value.ok) {
                const html = await announcementResult.value.text();
                const parsed = new DOMParser().parseFromString(html, 'text/html');
                const dataElement = parsed.getElementById('announcementData');
                const nextAnnouncements = dataElement ? JSON.parse(dataElement.textContent || '[]') : [];
                if (Array.isArray(nextAnnouncements)) {
                    announcements = nextAnnouncements;
                    if (localStorage.getItem(lastSeenKey) === null && announcements.length) {
                        localStorage.setItem(readKey, JSON.stringify(announcements.map(item => String(item.id))));
                        localStorage.setItem(lastSeenKey, String(announcements[0].id));
                    }
                }
            }

            if (notificationResult.status === 'fulfilled' && notificationResult.value.ok) {
                const data = await notificationResult.value.json();
                activityNotifications = Array.isArray(data.notifications) ? data.notifications : [];
                activityUnreadCount = Number(data.unread_count) || 0;
            }

            render();
        } catch (error) {
            console.warn('Could not refresh notifications:', error);
        } finally {
            loading = false;
        }
    }

    button.addEventListener('click', event => {
        event.stopPropagation();
        const open = dropdown.classList.toggle('open');
        button.setAttribute('aria-expanded', String(open));
        if (open) refresh();
    });
    dropdown.addEventListener('click', event => event.stopPropagation());
    document.addEventListener('click', () => {
        dropdown.classList.remove('open');
        button.setAttribute('aria-expanded', 'false');
    });
    readAllButton.addEventListener('click', async () => {
        localStorage.setItem(readKey, JSON.stringify(announcements.map(item => String(item.id))));
        await fetch(readAllUrl, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            credentials: 'same-origin'
        });
        activityNotifications = activityNotifications.map(item => ({ ...item, is_read: true }));
        activityUnreadCount = 0;
        render();
    });

    refresh();
    window.setInterval(refresh, 30000);
});
</script>
