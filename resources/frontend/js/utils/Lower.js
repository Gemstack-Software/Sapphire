export default (object) => {
    const newObject = {};

    for(let [a, b] of Object.entries(object)) {
        newObject[a.toLowerCase()] = b;
    }

    return newObject;
};