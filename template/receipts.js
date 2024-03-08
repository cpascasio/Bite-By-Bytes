const moment = require('moment');
let now = moment();

class receipts{
    constructor(receiptID, mainCode, sideCode, drinkCode, m1, s1, d1, originalPrice, comboID, discountPrice, totalPrice, name, date){
    
    this.receiptID = receiptID;
    this.name = name;
    this.mainCode = mainCode;
    this.sideCode = sideCode;
    this.drinkCode = drinkCode;
    this.m1 = m1;
    this.s1 = s1;
    this.d1 = d1;
    this.originalPrice = originalPrice;
    this.comboID = comboID;
    this.discountPrice = discountPrice;
    this.totalPrice = totalPrice;
    this.date = date;
    }
    

    /*
    constructor (main, side, drink, m1, s1, d1){
    this.main = main;
    this.side = side;
    this.drink = drink;
    this.m1 = m1;
    this.s1 = s1;
    this.d1 = d1;
        }

        */
}

module.exports = receipts;