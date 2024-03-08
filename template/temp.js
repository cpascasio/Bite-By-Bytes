class order{
    /*
    constructor(id, name, main, side, drink, m1, s1, d1, price, CMT, SVB, final, date){
    this.id = id;
    this.name = name;
    this.main = main;
    this.side = side;
    this.drink = drink;
    this.m1 = m1;
    this.s1 = s1;
    this.d1 = d1;
    this.price = price;
    this.CMT = CMT;
    this.SVB = SVB;
    this.final = final;
    this.date = date;
    }
    */

    constructor (main, side, drink, m1, s1, d1){
    this.main = main;
    this.side = side;
    this.drink = drink;
    this.m1 = m1;
    this.s1 = s1;
    this.d1 = d1;
        }

}

module.exports = order;