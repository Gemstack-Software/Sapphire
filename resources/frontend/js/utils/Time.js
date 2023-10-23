export const SecondsToTime = (seconds) => {
    seconds = parseInt(seconds)

    const minutes = Math.floor(seconds / 60) % 60
    const hours = Math.floor(seconds / 3600) % 24
    const days = Math.floor(seconds / (3600 * 24))

    return `${days}d ${hours}h ${minutes}m ${seconds % 60}s`
}