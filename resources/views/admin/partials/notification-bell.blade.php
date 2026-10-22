<div class="admin-notification-wrapper">
    <button class="admin-notification-button" type="button" data-admin-notifications-button aria-label="View notifications" aria-expanded="false">
        <i class="fa-regular fa-bell" aria-hidden="true"></i>
        <span class="admin-notification-badge" data-admin-notifications-badge hidden></span>
    </button>
    <div class="admin-notification-dropdown" data-admin-notifications-dropdown>
        <div class="admin-notification-header">
            <h3>Notifications</h3>
            <button type="button" data-admin-notifications-read-all>Mark all as read</button>
        </div>
        <div class="admin-notification-list" data-admin-notifications-list>
            <div class="admin-notification-empty">Loading notifications…</div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector('[data-admin-notifications-button]');
    const dropdown = document.querySelector('[data-admin-notifications-dropdown]');
    const badge = document.querySelector('[data-admin-notifications-badge]');
    const list = document.querySelector('[data-admin-notifications-list]');
    const readAllButton = document.querySelector('[data-admin-notifications-read-all]');
    if (!button || !dropdown || !badge || !list || !readAllButton) return;

    const feedUrl = @json(route('notifications.feed'));
    const readAllUrl = @json(route('notifications.read-all'));
    const readUrl = @json(route('notifications.read', ['notification' => '__notification__']));
    const csrfToken = @json(csrf_token());
    let notifications = [];
    let unreadCount = 0;
    let loading = false;

    function render() {
        badge.hidden = unreadCount < 1;
        badge.textContent = unreadCount > 99 ? '99+' : String(unreadCount);
        list.replaceChildren();

        if (!notifications.length) {
            const empty = document.createElement('div');
            empty.className = 'admin-notification-empty';
            empty.textContent = 'No notifications right now.';
            list.appendChild(empty);
            return;
        }

        notifications.forEach(item => {
            const row = document.createElement('a');
            row.className = 'admin-notification-item' + (item.is_read ? '' : ' unread');
            const destination = new URL(item.url || '/', window.location.origin);
            row.href = destination.origin === window.location.origin ? destination.href : @json(route('admin.dashboard'));

            const iconWrap = document.createElement('span');
            iconWrap.className = 'admin-notification-icon';
            const icon = document.createElement('i');
            const iconName = /^[a-z-]+$/.test(item.icon || '') ? item.icon : 'fa-bell';
            icon.className = 'fa-solid ' + iconName;
            iconWrap.appendChild(icon);

            const content = document.createElement('span');
            content.className = 'admin-notification-text';
            const title = document.createElement('strong');
            title.textContent = item.title || 'Dorm Portal update';
            const message = document.createElement('p');
            message.textContent = item.message || '';
            const time = document.createElement('small');
            time.className = 'admin-notification-time';
            time.textContent = item.created_human || 'Recently';
            content.append(title, message, time);
            row.append(iconWrap, content);

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
            list.appendChild(row);
        });
    }

    async function refresh() {
        if (loading) return;
        loading = true;
        try {
            const response = await fetch(feedUrl, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin', cache: 'no-store' });
            if (!response.ok) throw new Error('Notification feed request failed.');
            const data = await response.json();
            notifications = Array.isArray(data.notifications) ? data.notifications : [];
            unreadCount = Number(data.unread_count) || 0;
            render();
        } catch (error) {
            console.warn('Could not refresh admin notifications:', error);
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
        await fetch(readAllUrl, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            credentials: 'same-origin'
        });
        refresh();
    });

    refresh();
    window.setInterval(refresh, 30000);
});
</script>
