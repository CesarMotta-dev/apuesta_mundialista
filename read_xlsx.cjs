const xlsx = require('xlsx');
const fs = require('fs');
const workbook = xlsx.readFile('C:/Users/cesar/Downloads/WCup_2026_4.2.7_en.xlsx');
const sheet = workbook.Sheets['Matches'];
const json = xlsx.utils.sheet_to_json(sheet, { header: 1 });
fs.writeFileSync('database/data/matches_excel.json', JSON.stringify(json, null, 2));
console.log('Matches saved to matches_excel.json');
