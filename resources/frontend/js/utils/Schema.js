/**
 * Group types
 */
export const Type = (type) => {
    switch(type) {
        case 'ShortText':
        case 'MediumText':
        case 'LongText':
            return 'String';
            break;

        case 'IntNumber':
        case 'FloatNumber':
            return 'Number';
            break;

        case 'Date':
            return 'Date';
            break;
    }   

    return type
}