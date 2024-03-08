const express = require('express');
const app = express();
const moment = require('moment'); // time
const products = require('./products')
const path = require('path');
const bodyParser = require('body-parser');
const router = require('./routes/router'); //add
//const env = require('dotenv');


app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));
app.use(express.static(path.join(__dirname, 'public'))); // set static folder
app.use(bodyParser.urlencoded({ extended: true }));
app.use(express.json());
app.use('/api', router);

// Get ALL products
app.get('/api/products', (req, res) => res.json(products));

app.get('/', (req, res) => {
    res.render('index');
});

const axios = require('axios');

        let combo = [];

        async function fetchComboData() {
            try {
                console.log('TRYING TO FETCH DATA');

                const response = await axios.get('http://localhost:3000/api/combo'); // Replace with your API URL
                const comboData = response.data;

                combo = comboData;

                console.log('Fetched combo data:', comboData);

                return comboData;
            } catch (error) {
                console.error('Error fetching combo:', error);
            }
        }

app.post('/payment', async (req, res) => {
      // Check if the request came from the checkout button
      console.log("PAYMENT")
      console.log("Products:", req.body.product)
      console.log("Food Code:", req.body.foodCode)
      console.log("Price:",req.body.price)
      console.log("Quantity:",req.body.quantity)
      
      console.log(moment().format())

      let comboName = "";
    if (req.body && req.body.checkout) {
         if(req.body.quantity != 0){
            const productList = Array.isArray(req.body.product)
            ? req.body.product
            : [req.body.product]; // Ensure productList is an array

            const priceList = Array.isArray(req.body.price)
            ? req.body.price
            : [req.body.price]; // Ensure priceList is an array

            // Get the total quantity ordered
            const quantityList = Array.isArray(req.body.quantity)
                ? req.body.quantity
                : [req.body.quantity]; // Ensure quantityList is an array

            // const totalList = Array.isArray(req.body.total)
            // ? req.body.total
            // : [req.body.total]; // Ensure totalList is an array

            // const foodCode = Array.isArray(req.body.foodCode)
            // ? req.body.foodCode.map(item => parseInt(item, 10))
            // : [parseInt(req.body.foodCode, 10)];

            // // Convert req.body.foodCode to an array of integers using map and parseInt
            // req.body.foodCode = Array.isArray(req.body.foodCode)
            // ? req.body.foodCode.map(code => parseInt(code))
            // : [parseInt(req.body.foodCode)];

            let foodCode = [];

            if (typeof req.body.foodCode === 'string') {
            const foodCodeStrings = req.body.foodCode.split(',');
            foodCode = foodCodeStrings.map(item => parseInt(item.trim(), 10));
            }

            console.log(foodCode);
    
            //let quantity = req.body.quantity; 
            let totalDiscounted = 0;
            var comboedQuantity = [...req.body.quantity];
            let comboTotal = 0;
            let totalindividualOrders = 0;
            

            // Calculate the total price by summing up all the prices multiplied by the quantity
        let total = 0;
        for (let i = 0; i < priceList.length; i++) {
            total += parseFloat(priceList[i]) * parseInt(quantityList[i]);
        }
        console.log("total:", total); // This will log the calculated total as a single numeric value


        console.log("CHECK IF COMBO");
             // Fetch combo data and wait for the response
             await fetchComboData();

        
        // Assuming the foodCode is in req.body.foodCode

        let tempfoodCode = Array.isArray(req.body.foodCode)
                ? req.body.foodCode
                : [req.body.foodCode]; // Ensure quantityList is an array

                console.log("categoryNGASPGSAPOGASJGA:", req.body.category);


        let tempCategory = Array.isArray(req.body.category)
        ? req.body.category
        : [req.body.category]; // Ensure quantityList is an array

        var hasCombo = false;
        let discountPrice = 0;

        
        console.log("FIRSTtempfoodCode:", tempfoodCode);
        console.log("FIRSTtempCategory:", tempCategory);

        console.log("Printing comboData one by one:");

        let updatedFoodCode = [0,0,0];
        let updatedQuantity = [0,0,0];

        

            tempfoodCode.forEach((foodCode, index) => {
                if(tempCategory[index] == 'M' && updatedFoodCode[0] == 0){
                    updatedFoodCode[0] = foodCode; 
                }

                if(tempCategory[index] == 'S' && updatedFoodCode[1] == 0){
                    updatedFoodCode[1] = foodCode; 
                }

                if(tempCategory[index] == 'D' && updatedFoodCode[2] == 0){
                    updatedFoodCode[2] = foodCode; 
                }

          
              
            });
            

            console.log("QuantityLISTBASIS:", quantityList);

            let iterationQuantity = [...quantityList];


            let i = 0;
            updatedFoodCode.forEach((foodCode, index) => {
                //let i = 0;
                if(foodCode != 0){
                    updatedQuantity[index] = quantityList[i];
                    console.log("QuantityGETTINGTRANSFERRED:", iterationQuantity[i]);
                    i++;
                }
            });

        console.log("updatedfoodCode:", updatedFoodCode);
        console.log("updatedQuantity:", updatedQuantity);

        // let foodCode = updatedFoodCode;
        // let foodCode = req.body.foodCode.map(code => parseInt(code));
        foodCode = updatedFoodCode;

        combo.forEach((comboItem, index) => {
            console.log(`Combo ${index + 1}:`);
            console.log("Combo Code:", comboItem.comboID);
            console.log("Main Code:", comboItem.mainCode);
            console.log("Side Code:", comboItem.sideCode);
            console.log("drink Code:", comboItem.drinkCode);
            console.log("Combo Price:", comboItem.comboPrice);
            // Add other properties of comboItem as needed
            
            // Compare foodCode with mainCode, sideCode, and drinkCode
            console.log("Food Code:", foodCode[0]);
            console.log("Food Code:", foodCode[1]);
            console.log("Food Code:", foodCode[2]);
        if (comboItem.mainCode == foodCode[0] && comboItem.sideCode == foodCode[1] && comboItem.drinkCode == foodCode[2]) {
            console.log(`Food Code ${foodCode} exists in Combo ${index + 1}`);
            console.log('Food Code exists in comboData');

            hasCombo = true;
            comboName = comboItem.name; // Store the combo name
            //discountPrice = total - comboItem.comboPrice;
            // totalDiscounted = total - comboItem.comboPrice; // apply the discount
            totalDiscounted = comboItem.comboPrice;
            console.log("Total", total);
            console.log("total discounted:", totalDiscounted);
            comboID = comboItem.comboID;


            // COMBO AREA COMPUTATION
            // Compute the total of the combo
        // 1. find the lowest quantity among the 3 items
        const lowestNumber = Math.min.apply(null, quantityList);
        console.log("Lowest Number:", lowestNumber);

        // 2. multiply the lowest quantity by the combo price
        comboTotal = lowestNumber * comboItem.comboPrice;
        console.log("Combo Total:", comboTotal);

        

        

        console.log("BEFOREEE:", quantityList);

        comboedQuantity.forEach((quantity, index) => {
            quantity -= lowestNumber;
            comboedQuantity[index] = quantity;
        });



        comboedQuantity.forEach((quantity, index) => {
            totalindividualOrders += quantity * priceList[index];
        });
        
        // 3. subtract the combo total from the total
        totalDiscounted = comboTotal + totalindividualOrders;

        discountPrice = total - totalDiscounted;
        
        console.log("BEFOREEE:", quantityList);



        console.log("Comboed Quantity:", comboedQuantity);

        

        console.log("Discount Price:", discountPrice);
        console.log("Combo ID:", comboID);

        }else{
            console.log('Food Code does not exist in comboData');
            
            
            
        }
        });

        if(!hasCombo){
            console.log('NO COMBO')
            comboID = 0; // Store the combo name
            

        }

        foodCode = Array.isArray(updatedFoodCode)
            ? updatedFoodCode
            : [updatedFoodCode]; // Ensure priceList is an array

        
        console.log("listQuantitYYYYYYYy:", req.body.quantity);

        console.log("listQuantitYYYYYYYy:", quantityList);


        console.log("Combo Total AGAINGIAN:", comboTotal);

        console.log("QuantityCHECKER: ", updatedQuantity);

        console.log("PRODUCTCHECKER: ", productList);
        //console.log("COMBO NAME: ", comboName);


            res.render('payment', {
                listQuantity : quantityList,
                comboedQuantity: comboedQuantity,
                totalindividualOrders : totalindividualOrders,
                updatedQuantity : updatedQuantity,
                comboTotal: comboTotal,
                listPrice : priceList,
                listProduct: productList, // Use the productList array in the template
                totalDiscounted: totalDiscounted,
                total: total, // total of all products individually
                products: products, // Pass the products array to the template
                hasCombo: hasCombo,
                discountPrice: discountPrice,
                foodCode: foodCode,
                comboID: comboID,
                comboName: comboName
            })
         }
    } 



});

app.post('/receipt', (req, res) => {

    const productList = Array.isArray(req.body.product)
            ? req.body.product
            : [req.body.product]; // Ensure productList is an array

            const priceList = Array.isArray(req.body.price)
            ? req.body.price
            : [req.body.price]; // Ensure priceList is an array

            const listQuantity = Array.isArray(req.body.quantity)
            ? req.body.quantity
            : [req.body.quantity]; // Ensure priceList is an array

            // const foodCode = Array.isArray(req.body.foodCode)
            // ? req.body.foodCode
            // : [req.body.foodCode];

            // const foodCode = Array.isArray(req.body.foodCode)
            // ? req.body.foodCode.map(item => parseInt(item, 10))
            // : [parseInt(req.body.foodCode, 10)];

            // console.log("FOOD CODEEEEE", foodCode);

            let foodCode = [];

            if (typeof req.body.foodCode === 'string') {
            const foodCodeStrings = req.body.foodCode.split(',');
            foodCode = foodCodeStrings.map(item => parseInt(item.trim(), 10));
            }

            console.log(foodCode);



            let updatedQuantity = Array.isArray(req.body.updatedQuantity)
            ? req.body.updatedQuantity
            : [req.body.updatedQuantity];

            console.log("FOODCODEDEDEDEDEDEDEDEDEDEFOEGJEOFEEGFOJE : ", foodCode);


            // const totalList = Array.isArray(req.body.total)
            // ? req.body.total
            // : [req.body.total]; // Ensure totalList is an array

            // const totalDiscountedList = Array.isArray(req.body.totalDiscounted)
            // ? req.body.totalDiscounted
            // : [req.body.totalDiscounted]; // Ensure totalList is an array

            let total = req.body.total;
            let totalDiscounted = 0; // Initialize with the total

            let quantity = req.body.quantity;


            console.log("QUANTITY IN RECEIPT:", listQuantity);

            // if (quantity == 1) { // if only 1 item id ordered
            //     totalDiscounted = parseFloat(totalList); // Initialize with the total
            // }else{
            //     totalDiscounted = parseFloat(total[total.length - 1]); // Initialize with the total
            // }


            let change = 0;
            let hasCombo = req.body.hasCombo;
            let discountPrice = req.body.discountPrice;
            console.log("HAS COMBO?", hasCombo);

            console.log("discount price?", discountPrice);

            // if (hasCombo) { // If combo is applied
            //     change = req.body.cash - req.body.totalDiscounted;
            //     console.log("with combo", req.body.cash, "-", req.body.totalDiscounted);
            // } else { // If no combo is applied
            //     change = req.body.cash - total[total.length - 1];
            //     console.log("NO COMBO", req.body.cash, "-", total[total.length - 1]);
            // }

            let tempQuan0;

            if (hasCombo == 'true') {
                change = req.body.cash - req.body.totalDiscounted; // Use totalDiscounted instead of total[total.length - 1]
                console.log("with combo", req.body.cash, "-", req.body.totalDiscounted);
                totalDiscounted = req.body.totalDiscounted;




            } else {
                change = req.body.cash - total[total.length - 1]; // For the non-combo case, the change calculation is the same
                console.log("NO COMBO", req.body.cash, "-", total[total.length - 1]);
                totalDiscounted = 0;
            }

            console.log("comboTotal:", req.body.comboTotal);
            console.log("totalindividualOrders:", req.body.totalindividualOrders);
            finaltotal = parseFloat(req.body.comboTotal) + parseFloat(req.body.totalindividualOrders);
            console.log("FINAL TOTAL FINALINFLAIN:", finaltotal);

            console.log("foodCode0:", foodCode[0]);
            console.log("foodCode1:", foodCode[1]);
            console.log("foodCode2:", foodCode[2]);

            console.log("updatedquantity0:", req.body.updatedQuantity[0]);
            console.log("updatedquantity1:", req.body.updatedQuantity[2]);
            console.log("updatedquantity2:", req.body.updatedQuantity[4]);

            console.log("TAMA NA BA FOOD CODEEE?", foodCode);

    // From payment
    res.render('receipt', {
        cash : req.body.cash,
        customer : req.body.customer,
        total : total[total.length - 1] ,
        finaltotal: finaltotal,
        updatedQuantity: req.body.updatedQuantity,
        totalDiscounted: totalDiscounted,
        productList: req.body.product,
        priceList: req.body.price,
        quantity : req.body.quantity,
        listQuantity : req.body.quantity,
        comboedQuantity: req.body.comboedQuantity,
        comboTotal: req.body.comboTotal,
        totalindividualOrders : req.body.totalindividualOrders,
        listPrice : priceList,
        listProduct: productList, // Use the productList array in the template
        products: products, // Pass the products array to the template
        change: change,
        hasCombo: hasCombo,
        foodCode: foodCode,
        discountPrice: req.body.discountPrice[req.body.discountPrice.length - 1],
        comboID: req.body.comboID,
        comboName: req.body.comboName
    });

    console.log("RECEIPT")
    console.log("Customer:", req.body.customer)
    console.log("Cash:", req.body.cash)
    console.log("Total:", total[total.length - 1] )
    console.log("Total Discounted:", totalDiscounted)
    console.log("Product List:", req.body.product)
    console.log("Price List:", req.body.price)
    console.log("Quantity List:", req.body.quantity)
    console.log("Change:", change)
    console.log("Combo:", req.body.hasCombo)
    console.log("Food Code:", foodCode)
    console.log("Discount Price:", req.body.discountPrice)
    console.log("Combo ID:", req.body.comboID)
    console.log("Combo Name:", req.body.comboName)
});

app.listen(3000);

module.exports = app;