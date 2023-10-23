export const GetDiskSpace = () => {
    const value = parseInt(Math.random() * 1000000 - 100000) + 1e6
    
    const kb = value / 1024
    const mb = kb / 1024
    const gb = gb / 1024

    let returnValue = ''

    if(gb >= 1) returnValue = `${gb.toFixed(2)} GB`
    else if(mb >= 1) returnValue = `${mb.toFixed(2)} MB`
    else returnValue = `${kb.toFixed(2)} KB`

    return returnValue
}