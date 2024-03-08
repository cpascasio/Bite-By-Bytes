const db = require('./db');
const Receipt = require('../template/receipts');
const app = require('../server');
const moment = require('moment');
let now = moment();

// GET /api/orders
/*
gets all the orders
*/
exports.getOrders = (req, res, next) => {
    db.query('SELECT * FROM orders', (err, results) => {
            if (err) {
            console.error('Error executing MySQL query:', err);
            res.status(500).send('Error executing query');
            }else{
            res.json(results);
            }
        });
}

// GET /api/images
/*
gets all the images data
*/
exports.getImages = (req, res, next) => {
    db.query('SELECT i.imageID as imageID, i.image_data as image_data FROM images i', (err, results) => {
            if (err) {
            console.error('Error executing MySQL query:', err);
            res.status(500).send('Error executing query');
            }else{

            console.log("Query successful! from controller image");
            console.log(results);
            res.json(results);
            }
        });
}

// GET /api/food
/*
gets all the food data
*/
exports.getFood = (req, res, next) => {
    db.query('SELECT * FROM food', (err, results) => {
            if (err) {
            console.error('Error executing MySQL query:', err);
            res.status(500).send('Error executing query');
            }else{

            console.log("Query successful! from controller");
            console.log(results);
            res.json(results);
            }
        });
}

// GET /api/combo
/*
gets all the combo data
*/
exports.getCombo = (req, res, next) => {
    db.query('SELECT * FROM combos', (err, results) => {
            if (err) {
            console.error('Error executing MySQL query:', err);
            res.status(500).send('Error executing query');
            }else{

            console.log("Query successful! from controller");
            console.log(results);
            res.json(results);
            }
        });
}

// GET /api/orders/:id


exports.getReceipt = (req, res, next) => {
    const id = req.params.id;
    db.query('SELECT * FROM receipts WHERE receiptID = ?', [id], (err, results) => {
            if (err) {
            console.error('Error executing MySQL query:', err);
            res.status(500).send('Error executing query');
            }else{
            res.json(results);
            }
        });
}

// POST /api/receipts

exports.createReceipt = (req, res, next) => {
    console.log("ETO YUNG LAMAN SA DBBBBBBBBB QUERY");
    console.log(req.body);
    
    now = moment();
    // Get other required data from the request body
    /*
    const name = req.body.customer;
    const main = req.body.product0;
    const side = req.body.product1;
    const drink = req.body.product2;
    const m1 = req.body.quantity0;
    const s1 = req.body.quantity1;
    const d1 = req.body.quantity2;
    const originalPrice = req.body.originalPrice;
    const comboID = null;
    const discountPrice = null;
    const totalPrice = req.body.total;
    const date = req.body.date;
    */

    
    const main = req.body.product0;
    const side = req.body.product1;
    const drink = req.body.product2;
    const m1 = req.body.quantity0;
    const s1 = req.body.quantity1;
    const d1 = req.body.quantity2;
    const originalPrice = req.body.originalPrice;
    const comboID = req.body.comboID;
    const discountPrice = req.body.discountPrice;
    const totalPrice = req.body.total;
    const name = req.body.customer;
    const date = now.format("YYYY-MM-DD") + " " + now.format("HH:mm:ss");


    
    // Execute the SELECT query to get the maximum id from receipts table
    db.query('SELECT MAX(receiptID) AS maxId FROM receipts', (err, result) => {
        if (err) {
            console.error('Error executing MySQL query:', err);
            res.status(500).send('Error executing query');
        } else {
            // Retrieve the maximum id from the result
            const maxId = result[0].maxId || 0;
            
            // Increment the maxId to get the new id for the receipt
            const id = maxId + 1;
            
            // Create the receipt object
            const receipt = new Receipt(id, main, side, drink, m1, s1, d1, originalPrice, comboID, discountPrice, totalPrice, name, date);
            
            // Execute the INSERT query to insert the receipt into the receipts table
            db.query('INSERT INTO receipts SET ?', [receipt], (err, results) => {
                if (err) {
                    console.error('Error executing MySQL query:', err);
                    res.status(500).send('Error executing query');
                } else {
                    console.log("Order added successfully.");
                    res.redirect('/');
                }
            });
        }
    });
}


/*
exports.createOrder = (req, res, next) => {
    const main = "STEAK";
    const side = "STEAMED VEGETABLES";
    const drink = "WATER";
    const m1 = 1;
    const s1 = 2;
    const d1 = 1;

    
    const main = req.body.main;
    const side = req.body.side;
    const drink = req.body.drink;
    const m1 = req.body.m1;
    const s1 = req.body.s1;
    const d1 = req.body.d1;

    
    const order = new Order(main, side, drink, m1, s1, d1);

    console.log(order);

    db.query('INSERT INTO practice SET ?', [order], (err, results) => {
            if (err) {
            console.error('Error executing MySQL query:', err);
            res.status(500).send('Error executing query');
            }else{
            res.json(results);
            }
        });
}

*/

// PUT /api/receipts

exports.updateReceipts = (req, res, next) => {
    const id = req.params.id;
    const name = req.body.name;
    const main = req.body.main;
    const side = req.body.side;
    const drink = req.body.drink;
    const m1 = req.body.mainQuan;
    const s1 = req.body.sideQuan;
    const d1 = req.body.drinkQuan;
    const originalPrice = req.body.price;
    const comboID = req.body.comboID;
    const discountPrice = req.body.discountPrice;
    const totalPrice = req.body.total;
    const date = req.body.date;

    const order = new Order(id, name, main, side, drink, m1, s1, d1, originalPrice, comboID, discountPrice, totalPrice, date);

    db.query('UPDATE orders SET ? WHERE orderID = ?', [order, id], (err, results) => {
            if (err) {
            console.error('Error executing MySQL query:', err);
            res.status(500).send('Error executing query');
            }else{
            res.json(results);
            }
        });
}


exports.deleteOrders = (req, res, next) => {
    const id = req.params.id;
    db.query('DELETE FROM orders WHERE orderID = ?', [id], (err, results) => {
            if (err) {
            console.error('Error executing MySQL query:', err);
            res.status(500).send('Error executing query');
            }else{
            res.json(results);
            }
        });
}