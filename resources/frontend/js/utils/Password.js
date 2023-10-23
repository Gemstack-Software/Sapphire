export const PasswordStrength = (password) => {
    const length = password.length
    const has_uppercase = password.match(/[A-Z]/g)
    const has_number = password.match(/[0-9]/g)
    const has_special = password.match(/\W/g)

    let points = 0

    if(length > 8) points += 1
    if(length > 16) points += 1.25
    if(length > 24) points += 1.75
    if(length > 32) points += 2.5

    if(has_special) points *= 1.55
    if(has_uppercase) points *= 1.55
    if(has_number) points *= 1.35

    points = Math.ceil(points)

    if(points > 21) return {
        name: 'Unbeatable 😮',
        class: 'password-unbeatable',
        level: 4
    }

    if(points > 12) return {
        name: 'Very strong 😀',
        class: 'password-very-strong',
        level: 3
    }

    if(points > 7) return {
        name: 'Strong 🙂',
        class: 'password-strong',
        level: 2
    }

    if(points > 3) return {
        name: 'Moderate 😐',
        class: 'password-moderate', 
        level: 1
    }

    return {
        name: 'Weak 😞',
        class: 'password-weak',
        level: 0
    }
}

export const RandomPassword = () => {
    const lower_letters = "abcdefghijklmnoprstuwxyz"
    const upper_letters = lower_letters.toUpperCase()
    const numbers = "0123456789"
    const specials = "!@#$%^&*()_-+={[]}|\\':;\"<,>.?/"
    const charset = lower_letters + upper_letters + numbers + specials
    const length = 24 + Math.random() * 30

    let new_password = ''
    
    for(let i = 0; i < length; i++) 
        new_password += charset[parseInt(Math.random() * charset.length)]

    return new_password
}