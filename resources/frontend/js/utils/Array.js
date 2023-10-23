export const MakeArrayFromObject = (object = {}) => {
    const array = []

    for(let item of Object.entries(object ? object : {})) {
        array.push(item)
    }

    return array
}

/**
 * Compares 2 arrays if they have this same content
 * 
 * Reason of this function is that when we have array made using Array.from() from Proxy (example from vue's state (ref(...))) 
 * when you compare this array with "normal" array with this same content it will return false 
 */
export const CompareArrays = (arr1, arr2) => {
    const len1 = arr1.length
    const len2 = arr2.length

    if(len1 !== len2) return false;

    for(let i = 0; i < len1; i++) {
        if(arr1[i] !== arr2[i]) return false;
    }

    return true;
}