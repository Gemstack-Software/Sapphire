export const FormatDate = (x) => ((x < 10) ? ("0" + x) : (x))
export const CreateDate = (date) => `${FormatDate(date.getDate())}-${FormatDate(date.getMonth() + 1)}-${FormatDate(date.getFullYear())}`