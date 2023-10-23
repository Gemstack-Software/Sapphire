export const GetSalesEarnings = () => {
    const money = 1e4 + parseInt(Math.random() * 1e4)
    const currency = "USD"

    return money.toLocaleString("fi-FI", { style: "currency", currency })
}