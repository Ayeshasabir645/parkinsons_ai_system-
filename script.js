function renderLayout(activePage) {
    var navLinks = [
        { href: 'dashboard.html',      ico: '📊', label: 'Dashboard' },
        { href: 'hospitals.html',       ico: '🏥', label: 'Hospitals' },
        { href: 'prediction.html',      ico: '🔮', label: 'Prediction' },
        { href: 'explainability.html',  ico: '📈', label: 'Explainability' },
        { href: 'training.html',        ico: '⚙️',  label: 'Training' },
    ];

    var navHTML = '<div class="sb-section">Main</div>';

    for (var i = 0; i < navLinks.length; i++) {
        var link = navLinks[i];
        var activeClass = '';
        if (link.label === activePage) {
            activeClass = 'active';
        }

        navHTML += '<a href="' + link.href + '" class="' + activeClass + '">';
        navHTML += '<span class="nav-ico">' + link.ico + '</span>';
        navHTML += link.label;
        navHTML += '</a>';
    }

    var sidebarHTML = '';
    sidebarHTML += '<div class="sidebar">';
    sidebarHTML +=   '<div class="sb-header">';
    sidebarHTML +=     '<div class="sb-brand">';
    sidebarHTML +=       '<div class="sb-icon">🧠</div>';
    sidebarHTML +=       '<div class="sb-title">Parkinson\'s<br/>AI System</div>';
    sidebarHTML +=     '</div>';
    sidebarHTML +=   '</div>';
    sidebarHTML +=   '<nav class="sb-nav">' + navHTML + '</nav>';
    sidebarHTML +=   '<div class="sb-footer">';
    sidebarHTML +=     '<a href="login.html"><span>🚪</span> Logout</a>';
    sidebarHTML +=   '</div>';
    sidebarHTML += '</div>';

    document.getElementById('sidebar-placeholder').innerHTML = sidebarHTML;


    var notifHTML = '';

    notifHTML += '<div class="notif-item unread">';
    notifHTML +=   '<div class="notif-ico" style="background:#e8f1fb;">🔄</div>';
    notifHTML +=   '<div class="notif-body">';
    notifHTML +=     '<div class="notif-msg">Round 15 training completed</div>';
    notifHTML +=     '<div class="notif-time">2 mins ago · Hospital A</div>';
    notifHTML +=   '</div>';
    notifHTML +=   '<div class="notif-dot"></div>';
    notifHTML += '</div>';

    notifHTML += '<div class="notif-item unread">';
    notifHTML +=   '<div class="notif-ico" style="background:#fdf0f0;">⚠️</div>';
    notifHTML +=   '<div class="notif-body">';
    notifHTML +=     '<div class="notif-msg">Failed login attempt detected</div>';
    notifHTML +=     '<div class="notif-time">20 mins ago · Hospital F</div>';
    notifHTML +=   '</div>';
    notifHTML +=   '<div class="notif-dot"></div>';
    notifHTML += '</div>';

    notifHTML += '<div class="notif-item">';
    notifHTML +=   '<div class="notif-ico" style="background:#e8f7ef;">✅</div>';
    notifHTML +=   '<div class="notif-body">';
    notifHTML +=     '<div class="notif-msg">Global model updated to v2.4.1</div>';
    notifHTML +=     '<div class="notif-time">1 hr ago · System</div>';
    notifHTML +=   '</div>';
    notifHTML += '</div>';

    notifHTML += '<div class="notif-item">';
    notifHTML +=   '<div class="notif-ico" style="background:#e8f1fb;">🏥</div>';
    notifHTML +=   '<div class="notif-body">';
    notifHTML +=     '<div class="notif-msg">Hospital E reconnected</div>';
    notifHTML +=     '<div class="notif-time">3 hrs ago · Hospital E</div>';
    notifHTML +=   '</div>';
    notifHTML += '</div>';

    var topbarHTML = '';
    topbarHTML += '<div class="topbar">';
    topbarHTML +=   '<div class="topbar-search">';
    topbarHTML +=     '<input type="text" placeholder="Search anything…"/>';
    topbarHTML +=   '</div>';
    topbarHTML +=   '<div class="topbar-right">';

    topbarHTML +=     '<div class="dropdown-wrap" id="notif-wrap">';
    topbarHTML +=       '<button class="notif-btn" onclick="toggleDropdown(\'notif-wrap\')">🔔';
    topbarHTML +=         '<span class="notif-badge" id="notif-badge">2</span>';
    topbarHTML +=       '</button>';
    topbarHTML +=       '<div class="dropdown" id="notif-dropdown">';
    topbarHTML +=         '<div class="dd-header">';
    topbarHTML +=           '<span class="dd-title">Notifications</span>';
    topbarHTML +=           '<button class="dd-clear" onclick="clearNotifs()">Mark all read</button>';
    topbarHTML +=         '</div>';
    topbarHTML +=         '<div class="notif-list">' + notifHTML + '</div>';
    topbarHTML +=       '</div>';
    topbarHTML +=     '</div>';


    topbarHTML +=     '<div class="dropdown-wrap" id="user-wrap">';
    topbarHTML +=       '<div class="user-chip" onclick="toggleDropdown(\'user-wrap\')">';
    topbarHTML +=         '<div class="user-avatar">👨‍⚕️</div>';
    topbarHTML +=         '<div>';
    topbarHTML +=           '<div class="user-name">Dr. Rizwan Ali</div>';
    topbarHTML +=           '<div class="user-role">Admin</div>';
    topbarHTML +=         '</div>';
    topbarHTML +=         '<span class="dd-chevron">▾</span>';
    topbarHTML +=       '</div>';
    topbarHTML +=       '<div class="dropdown user-dropdown" id="user-dropdown">';
    topbarHTML +=         '<div class="user-dd-head">';
    topbarHTML +=           '<div class="user-avatar" style="width:42px;height:42px;font-size:20px;">👨‍⚕️</div>';
    topbarHTML +=           '<div>';
    topbarHTML +=             '<div style="font-weight:600;font-size:14px;color:var(--navy);">Dr. Saqib Ali</div>';
    topbarHTML +=             '<div style="font-size:12px;color:var(--text3);">saqib@hospital.pk</div>';
    topbarHTML +=           '</div>';
    topbarHTML +=         '</div>';
    topbarHTML +=         '<div class="dd-divider"></div>';
    topbarHTML +=         '<div class="user-dd-item" onclick="window.location.href=\'login.html\'" style="color:var(--red);">🚪&nbsp; Logout</div>';
    topbarHTML +=       '</div>';
    topbarHTML +=     '</div>';

    topbarHTML +=   '</div>';
    topbarHTML += '</div>';

    document.getElementById('topbar-placeholder').innerHTML = topbarHTML;

    document.addEventListener('click', function(e) {
        var clickedInsideDropdown = e.target.closest('.dropdown-wrap');
        if (!clickedInsideDropdown) {
            var allDropdowns = document.querySelectorAll('.dropdown');
            for (var i = 0; i < allDropdowns.length; i++) {
                allDropdowns[i].classList.remove('open');
            }
        }
    });

    document.addEventListener('click', function(e) {
        var item = e.target.closest('.notif-item');
        if (!item) return;

        item.classList.remove('unread');

        var dot = item.querySelector('.notif-dot');
        if (dot) {
            dot.remove();
        }

        updateBadge();
    });
}


function toggleDropdown(wrapId) {
    var allDropdowns = document.querySelectorAll('.dropdown');
    var wrap = document.getElementById(wrapId);
    var dropdown = wrap.querySelector('.dropdown');

    var wasOpen = dropdown.classList.contains('open');

    for (var i = 0; i < allDropdowns.length; i++) {
        allDropdowns[i].classList.remove('open');
    }

    if (!wasOpen) {
        dropdown.classList.add('open');
    }
}


function updateBadge() {
    var unreadItems = document.querySelectorAll('.notif-item.unread');
    var count = unreadItems.length;

    var badge = document.getElementById('notif-badge');
    if (badge) {
        badge.textContent = count;
        if (count === 0) {
            badge.style.display = 'none';
        } else {
            badge.style.display = '';
        }
    }
}

function clearNotifs() {
    var allItems = document.querySelectorAll('.notif-item');

    for (var i = 0; i < allItems.length; i++) {
        allItems[i].classList.remove('unread');

        var dot = allItems[i].querySelector('.notif-dot');
        if (dot) {
            dot.remove();
        }
    }

    updateBadge();
}

function buildChart(id, accData, lossData) {
    var container = document.getElementById(id);
    if (!container) return;

    container.innerHTML = '';
    for (var i = 0; i < accData.length; i++) {
        var bar = document.createElement('div');
        bar.className = 'chart-bar';
        bar.style.height = accData[i] + '%';
        bar.style.background = '#1e6ec8';
        bar.style.opacity = '0.85';
        bar.style.width = '13px';
        bar.title = 'Accuracy: ' + accData[i] + '%';
        container.appendChild(bar);
    }

    for (var j = 0; j < lossData.length; j++) {
        var bar2 = document.createElement('div');
        bar2.className = 'chart-bar';
        bar2.style.height = lossData[j] + '%';
        bar2.style.background = '#d63c3c';
        bar2.style.opacity = '0.7';
        bar2.style.width = '13px';
        bar2.title = 'Loss: ' + lossData[j] + '%';
        container.appendChild(bar2);
    }
}
