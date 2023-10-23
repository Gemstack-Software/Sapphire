export const RemoveNumeric = (object) => {
    const newObject = {}

    for(let [a, b] of Object.entries(object)) {
        if(isNaN(a)) newObject[a] = b
    }

    return newObject
}