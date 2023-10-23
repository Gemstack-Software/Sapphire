import { Capitalize } from "./String"

export const FormatItemName = (name) => {
    return Capitalize(name.replace(/_/g, ' '))
}