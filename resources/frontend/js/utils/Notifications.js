/**
 * GetNotificationContainer()
 * 
 * @returns Container for notifications
 */
const GetNotificationContainer = () => {
    let notificationContainer;

    if(notificationContainer = document.querySelector(".notification-container"))
        return notificationContainer;

    notificationContainer = document.createElement("div")
    notificationContainer.classList.add("notification-container")

    document.body.append(notificationContainer)

    // This function could `return notificationContainer` but it returns reference to virtual element and we want actual from document
    return GetNotificationContainer() 
}

/**
 * CreateNotification()
 * 
 * @returns Notification HTML element ready to append to NotificationContainer
 */
const CreateNotification = (content, color, icon) => {
    const notificationRoot = document.createElement("div")
    notificationRoot.classList.add("notification__root")

    notificationRoot.innerHTML = `
        <div class="notification__left" style="background: ${color}">
            <em class="${icon}"></em>
        </div>
        <div class="notification__right">
            ${content}
        </div>
    `

    notificationRoot.setAttribute("onclick", "this.remove()")

    return notificationRoot
}

/**
 * Notify() 
 * 
 * @param content {String} - Contains the content of notification
 * @param color {String} - Cotnains the background-color of notification icon
 * @param icon {String} - Contains the icon of notification
 * 
 * Function Notify() places new notification in a notification container
 * It's not a class because it's the simple ony-purpose function
 * It can be used in class e.g. WarningNotification or SuccessNotification etc
 */
const Notify = (content, color, icon) => {
    const notificationContainer = GetNotificationContainer()
    const notification = CreateNotification(content, color, icon)

    notificationContainer.append(notification)
}


export const NotifyRed = "rgb(252, 51, 51)"
export { Notify }