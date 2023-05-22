export function sleep(ms){
    return new Promise((resolve)=>{ setTimeout(resolve, ms)})
} 
export function moneyFormat(value){
    let moneyOptions = {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    };

    let money = value;
    if(money.match('.')) money = money.replaceAll('.', '')
    if(money.match(',')) money = money.replace(',', '.');

    money = parseFloat(money);

    return money.toLocaleString('pt-br', moneyOptions)
}