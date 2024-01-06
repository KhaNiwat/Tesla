<!DOCTYPE html>
<html>
<head>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100;300&family=Roboto+Slab:wght@300&display=swap");
    * {
      font-family: "Noto Sans Thai", sans-serif;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    header {
      text-align: center;
      align-items: center;
      justify-content: center;
      margin: 1rem auto;
    }
    header h1{
      font-weight: bold;
      font-size: 50px;
    }

    table {
      width: 60%;
      border-collapse: collapse;
      margin: 0 auto;
      position: relative;
      left: 0;
    }

    th,
    td {
      padding: 4px;
      text-align: center;
    }

    th {
      background-color: #f2f2f2;
    }
    tr:nth-child(odd) {
      background-color: #f0f0f0;
    }

    #pagination {
      display: flex;
      justify-content: center;
    }

    #pagination button {
      margin: 5px;
      background-color: #000;
      color: white;
      padding: 8px;
    }
    button {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      border-radius: 5px;
      transition: background-color;
    }

    #search-bar {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 1rem auto;
    }

    #search-input {
      width: 20%;
      padding: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-right: 10px;
    }
  </style>

  <script>
    let currentPage = 0;
    let dataPerPage = 10;
    let objectData = null;

    async function getDataFromAPI() {
      let response = await fetch(
        "https://data.go.th/dataset/24c949fc-a032-480e-a7ce-7f88ac41f00e/resource/913fd3cc-e839-4c00-a5d6-07e6c073752c/download/department_store.json"
      );
      let rawData = await response.text();
      objectData = JSON.parse(rawData);
      displayData(currentPage);
    }

    function displayData(page) {
      let resultTable = document.getElementById("result-table");
      resultTable.innerHTML = "";

      let tableHeader = resultTable.createTHead();
      let headerRow = tableHeader.insertRow(0);
      headerRow.insertCell(0).innerHTML = "ลำดับ";
      headerRow.insertCell(1).innerHTML = "ชื่อห้าง";
      headerRow.insertCell(2).innerHTML = "โลเคชั่น";

      for (let i = page * dataPerPage; i < (page + 1) * dataPerPage; i++) {
        if (i >= objectData.features.length) {
          break; 
        }
        let rowData = objectData.features[i].properties;
        let row = resultTable.insertRow(-1);
        row.insertCell(0).innerHTML = i + 1;
        row.insertCell(1).innerHTML = rowData.name;
        let mapButtonCell = row.insertCell(2);
        let mapButton = document.createElement("button");
        mapButton.textContent = "Google Map";
        mapButton.addEventListener("click", function () {
          goMap(rowData.name);
        });
        mapButtonCell.appendChild(mapButton);
      }

      createPaginationButtons();
    }

    function createPaginationButtons() {
      let totalPages = Math.ceil(objectData.features.length / dataPerPage);
      let pagination = document.getElementById("pagination");
      pagination.innerHTML = "";

      for (let i = 0; i < totalPages; i++) {
        let button = document.createElement("button");
        button.textContent = i + 1;
        button.addEventListener("click", function () {
          currentPage = i;
          displayData(currentPage);
        });
        pagination.appendChild(button);
      }
    }

    function goMap(name) {
      const url = "https://www.google.co.th/maps/search/" + name;
      window.location.href = url;
    }

    function searchByName(searchText) {
      // ค้นหาชื่อห้าง
      const results = objectData.features.filter((feature) =>
        feature.properties.name.toLowerCase().includes(searchText)
      );
      return results;
    }

    function displaySearchResults(results) {
      const resultTable = document.getElementById("result-table");
      resultTable.innerHTML = "";
      for (let i = 0; i < results.length; i++) {
        let rowData = results[i].properties;
        let row = resultTable.insertRow(-1);
        row.insertCell(0).innerHTML = i + 1;
        row.insertCell(1).innerHTML = rowData.name;
        let mapButtonCell = row.insertCell(2);
        let mapButton = document.createElement("button");
        mapButton.textContent = "Google Map";
        mapButton.addEventListener("click", function () {
          goMap(rowData.name);
        });
        mapButtonCell.appendChild(mapButton);
      }
    }

    function displayNoResultsMessage() {
      const resultTable = document.getElementById("result-table");
      resultTable.innerHTML = "ไม่พบผลลัพธ์ที่ค้นหา";
    }

    document.addEventListener("DOMContentLoaded", function () {
      getDataFromAPI();

      const searchButton = document.getElementById("search-button");
      const searchInput = document.getElementById("search-input");

      searchButton.addEventListener("click", function () {
        const searchText = searchInput.value.trim().toLowerCase();
        if (searchText !== "") {
          const results = searchByName(searchText);
          if (results.length > 0) {
            displaySearchResults(results);
          } else {
            displayNoResultsMessage();
          }
        }
      });
    });
  </script>
</head>
<body>
  <header><h1>EV Charging Station</h1></header>
  <main>
    <div id="search-bar">
      <input type="text" id="search-input" placeholder="ค้นหาชื่อห้าง...">
      <button id="search-button">ค้นหา</button>
    </div>
    <table id="result-table"></table>
    <br /><br />
    <div id="pagination"></div>
  </main>
</body>
