    document.addEventListener("DOMContentLoaded", function () {
    fetchNotifications();

    document
        .getElementById("notification-icon")
        .addEventListener("click", function () {
        markNotificationsAsRead();
        });
    });

    function fetchNotifications() {
    fetch("../backend/modules/orders/get_notifications.php") // Fetch all notifications from the backend
        .then((response) => response.json())
        .then((data) => {
        let countSpan = document.getElementById("notification-count");
        let notificationList = document.getElementById("notification-list");

        // Update unread notification count
        if (data.unread_count > 0) {
            countSpan.innerText = data.unread_count;
            countSpan.style.display = "inline-block";
        } else {
            countSpan.style.display = "none";
        }

        // Populate notifications dropdown
        let listContent = "";
        if (data.notifications.length > 0) {
            data.notifications.forEach((notification) => {
            let isUnread = notification.status === "unread";
            listContent += `
                            <li class="dropdown-item d-flex justify-content-between align-items-center notification-item 
                                ${
                                isUnread ? "fw-bold bg-light" : "text-muted"
                                } p-2 rounded-2"
                                data-id="${notification.id}" data-status="${
                notification.status
            }" style="cursor: pointer;">
                                <span>${notification.message}</span>
                                ${
                                isUnread
                                    ? '<span class="badge bg-success">New</span>'
                                    : ""
                                }
                            </li>
                        `;
            });
        } else {
            listContent = `<li class="text-center text-muted m-2">No notifications</li>`;
        }

        notificationList.innerHTML = listContent;
        }).catch((error) => console.log("Error fetching notifications:", error));
    }

    // Mark notifications as read
    function markNotificationsAsRead() {
    fetch("../backend/modules/orders/mark_notifications_read.php") // API to mark all notifications as read
        .then((response) => response.json())
        .then(() => {
        document.getElementById("notification-count").style.display = "none";

        // Update styling of unread notifications
        document.querySelectorAll(".notification-item").forEach((item) => {
            item.classList.remove("fw-bold", "text-dark");
            item.classList.add("text-muted");

            let badge = item.querySelector(".badge");
            if (badge) badge.remove(); // Remove the "New" badge
        });
        })
        .catch((error) =>
        console.log("Error marking notifications as read:", error)
        );
    }
