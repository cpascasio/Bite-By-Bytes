let list = document.querySelector('.list');
let listCard = document.querySelector('.listCard');
let body = document.querySelector('body');
let total = document.querySelector('.total');
let quantity = document.querySelector('.quantity');


// conn.query('SELECT * FROM food', function(err, foodData){
//     console.log("Query successful!", foodData);
//   });



 let products = [];
 let images = [];

 async function fetchData() {
    try {
        console.log('TRYING TO FETCH DATA');

      const response = await fetch('/api/food');
      const foodData = await response.json();

      products = foodData;

      const response2 = await fetch('/api/images');
        const imageData = await response2.json();

        images = imageData;

      console.log('Fetched food data:', foodData);
        console.log('Fetched image data:', imageData);


        
      initApp();
    } catch (error) {
      console.error('Error fetching products:', error);
    }
  }

    fetchData();

/*
let products = [
    {
        foodCode: 1,
        name: 'STEAK',
        category: 'M',
        price: 900,
        image: 'https://www.lemonblossoms.com/wp-content/uploads/2018/05/Pan_Seared_Steak_Recipe_S3-500x500.jpg',
    },
    {
        foodCode: 2,
        name: 'SALMON',
        category: 'M',
        image: 'image2.PNG',
        price: 850
    },
    {
        foodCode: 3,
        name: 'CHICKEN',
        category: 'M',
        image: 'image3.PNG',
        price: 300
    },
    {
        foodCode: 4,
        name: 'BAKED POTATO',
        category: 'S',
        image: 'image4.PNG',
        price: 80
    },
    {
        foodCode: 5,
        name: 'MASHED POTATO',
        category: 'S',
        image: 'image5.PNG',
        price: 75
    },
    {
        foodCode: 6,
        name: 'STEAMED VEGETABLES',
        category: 'S',
        image: 'image6.PNG',
        price: 50
    },
    {
        foodCode: 7,
        name: 'ICED TEA',
        category: 'D',
        image: 'image7.PNG',
        price: 55
    },
    {
        foodCode: 8,
        name: 'ROOT BEER',
        category: 'D',
        image: 'image8.PNG',
        price: 60
    },
    {
        foodCode: 9,
        name: 'WATER',
        category: 'D',
        image: 'image9.PNG',
        price: 20
    },
    {
        foodCode: 10,
        name: 'FISH FILLET',
        category: 'M',
        image: 'image9.PNG',
        price: 20
    },
];

*/


let listCards  = [];


// Products on Main Page
// CLASSIFIES THE PRODUCTS AND DOES NOT RESET THE KEY VALUE
function initApp() {

    // Assign the fetched data to the 'products' array
    //products = foodData;

    products.forEach((product) => {
        // Find the corresponding image_data for the product
        const matchingImage = images.find((image) => image.imageID === product.imageID);
    
        // If a matching image is found, update the product's image property
        if (matchingImage) {
          product.image = matchingImage.image_data;
        }
      });

    // Sort the products array based on the 'category' property
    // products.sort((a, b) => a.category.localeCompare(b.category));

    // ... Continue with the existing logic to display the products in categorized sections
    // (You may keep the rest of the initApp() function as it is)
  

    console.log('Fetched food data:RWARAWRAWRAWRAWRAWRAWRAWR');
    /*
    products.sort((a, b) => {
        const categoryOrder = { 'M': 1, 'S': 2, 'D': 3 };
        return categoryOrder[a.category] - categoryOrder[b.category];
    });

    */
    // // Sort the products array based on the 'category' property
    // products.sort((a, b) => a.category.localeCompare(b.category));
    // Define the custom category order
  const categoryOrder = {
    'M': 1, // Main Dishes
    'S': 2, // Side Dishes
    'D': 3  // Drinks
  };

  // Sort the products array based on the custom category order
  products.sort((a, b) => categoryOrder[a.category] - categoryOrder[b.category]);
  
    let currentTitle = '';
    let currentDesc = '';
  
    products.forEach((value, key) => {
      // Check if a new category is encountered
      if (key === 0 || value.category !== products[key - 1].category) {
        // Set the title and description based on the category 
        if (value.category === 'M') { // ┌── ⋆⋅☆⋅⋆ ──┐ ╔══《✧》══╗ ◦∘ *+:｡.｡　　｡.｡:+*
          currentTitle = '═════════ ∘◦ Main Dishes ◦∘ ═════════'; // --------------------------- Main Dishes ---------------------------
          currentDesc = '————-————-————-————- You can only choose 1 Main Dish ————-————-————-————-'; // ------------------------------------------- You can only choose 1 Main Dish -------------------------------------------
        } 
        
        if (value.category === 'S') {
          currentTitle = '═════════ ∘◦ Side Dishes ◦∘ ═════════'; // --------------------------- Side Dishes ---------------------------
          currentDesc = '————-————-————-————- You can only choose 1 Side Dish ————-————-————-————-'; // ------------------------------------------- You can only choose 1 Side Dish -------------------------------------------
        }
        
        if (value.category === 'D') {
          currentTitle = '═════════ ∘◦ Drinks ◦∘ ═════════'; // --------------------------- Drinks ---------------------------
          currentDesc = '————-————-————-————- You can only choose 1 Drink ————-————-————-————-'; // -------------------------------------------------- You can only choose 1 Drink ------------------------------------------------
        }

        let titleDiv = document.createElement('div');
        titleDiv.classList.add('title');
        titleDiv.innerHTML = `<h2 style="color: #DA7E0D; font-size:32px; font-weight:bold">${currentTitle}</h2>`;
        list.appendChild(titleDiv);
  
        let descDiv = document.createElement('div');
        descDiv.classList.add('desc');
        descDiv.innerHTML = `<p style="color: #DA7E0D">${currentDesc}</p>`;
        list.appendChild(descDiv);
      }
  
      let newDiv = document.createElement('div');
      newDiv.classList.add('item');
      newDiv.innerHTML = `
        <img src="${value.image}"> 
        <div class="title">${value.name}</div>
        <div class="price">₱${value.price.toLocaleString()}.00</div>
        <button id="${key}" onclick="addToCard(${key})">Add To Cart</button>
        `;
  
      list.appendChild(newDiv);
    });
  }


// Call the initApp() function to display the data
initApp();

function addToCard(key) {
    const product = products[key];
    const category = product.category;
  
    if (!listCards[key]) {
      
      // Include the 'category' property in the listCards array when adding products
      listCards[key] = {
        ...JSON.parse(JSON.stringify(products[key])),
        category: products[key].category
      };
      listCards[key].quantity = 1;
  
      // Disable add to cart buttons of products in the same category
      const buttons = document.querySelectorAll('.item button');
      buttons.forEach((button, index) => {
        const productKey = parseInt(button.id);
        if (products[productKey].category === category) {
            button.disabled = true;
        } else {
            button.disabled = false;
        }
      });
    }
    
    reloadCard();
  }
  

// Product List Purhased on Cart
function reloadCard(){
    listCard.innerHTML = '';
    let count = 0;
    let totalPrice = 0;
    
    listCards.forEach((value, key)=>{
        const product = products[key];
        totalPrice = totalPrice + value.price;
        count = count + value.quantity;
        if(value != null){
            let newDiv = document.createElement('li');
            newDiv.innerHTML = `
                <div><img src="${product.image}"/></div>
                <input type="hidden" class="foodCode-input" value="${product.foodCode}" name="foodCode" size="10" onchange="updateName(${key}, this)" readonly>
                <input type="hidden" class="foodCode-input" value="${product.category}" name="category" size="10" onchange="updateName(${key}, this)" readonly>
                <div>${product.name}<input type="hidden" class="name-input" value="${product.name}" name="product" size="10" onchange="updateName(${key}, this)" readonly></div>
                <div>${product.price}<input type="hidden" class="price-input" value="${product.price}" name="price" style="wfoodCodeth: 3em" onchange="updatePrice(${key}, this)" readonly></div>
                <div>
                    <button onclick="changeQuantity(${key}, ${value.quantity - 1})">-</button>
                    <div>${value.quantity}</div>
                    <input type="hidden" class="count" id="quantity-${key}" value="${value.quantity}" name="quantity" style="width: 1.8em" min="1" readonly">
                    <button onclick="changeQuantity(${key}, ${value.quantity + 1})">+</button>
                </div>
                <input type="hidden" class="total" value="${totalPrice}" name="total" onchange="updateQuantity(${key}, this) readonly">
                </div>`;
                listCard.appendChild(newDiv);
        }
    })
    total.innerText = totalPrice.toLocaleString();
    quantity.innerText = count;
}

function changeQuantity(key, quantity) {
    if (quantity === 0) {
        delete listCards[key];

        // Check if there are any products left in the listCards for the category
        const category = products[key].category;
        const categoryProducts = Object.values(listCards).filter((card) => card.category === category);

        // If no products are left in the listCards for the category, enable the buttons for that category
        if (categoryProducts.length === 0) {
            const buttons = document.querySelectorAll('.item button');
            buttons.forEach((button, index) => {
                const productKey = parseInt(button.id);
                if (products[productKey].category === category) {
                    button.disabled = false;
                }
            });
        }
    } else {
        listCards[key].quantity = quantity;
        listCards[key].price = quantity * products[key].price;
    }
    reloadCard();
}

