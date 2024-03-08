const fetch = require('node-fetch');

let combo = [];

async function fetchComboData() {
  try {
    console.log('TRYING TO FETCH DATA');

    const response = await fetch('/api/combo');
    const comboData = await response.json();

    combo = comboData;

    console.log('Fetched combo data:', comboData);

    return comboData; 
  } catch (error) {
    console.error('Error fetching combo:', error);
  }
}

module.exports = fetchComboData;
