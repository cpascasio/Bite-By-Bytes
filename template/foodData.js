const moment = require('moment');
let now = moment();

class foodData{
    constructor(foodCode, name, category, price, imageID){
    this.foodCode = foodCode;
    this.name = name;
    this.category = category;
    this.price = price;
    this.imageID = imageID;
    }
}

module.exports = foodData;