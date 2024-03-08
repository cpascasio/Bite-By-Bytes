const express = require('express');
const router = express.Router();

const database = require('../database/Controller'); //add

// // Get ALL products
/*
router.get('/api/food', (req, res) => {
    db.query('SELECT * FROM food', (err, foodData) => {
        if (err) {
            console.error('Error executing MySQL query:', err);
            res.status(500).send('Error executing query');
        } else {
            console.log(foodData);
            res.render('index', { foodData: foodData }); // Pass 'results' to the 'index' view as 'foodData' variable
        }
    });
});
*/

router.post('/receipts', database.createReceipt); //add
router.get('/receipts', database.getReceipt); //add
router.get('/food', database.getFood); //add
router.get('/images', database.getImages); //add
router.get('/combo', database.getCombo); //add

//router.get()

module.exports = router;