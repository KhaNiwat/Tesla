<!DOCTYPE html>
<html>

<head>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100;300&family=Roboto+Slab:wght@300&display=swap");

        * {
            font-family: "Noto Sans Thai", sans-serif;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
            background-color: #aed6ee;
            padding: 10px;
            border-radius: 5px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination button {
            margin: 0 5px;
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>สถานีซ่อมบำรุงรถไฟฟ้า</h1>
        <input type="text" id="search" class="search" placeholder="ค้นหาข้อมูล">

        <ul id="result"></ul>

        <div class="pagination" id="pagination"></div>
    </div>

    <script>
        let objectData = null;
        let currentPage = 1;
        let dataPerPage = 25;
        let page = 1;
        async function getDataFromAPI() {
            let response = await fetch('https://data.go.th/dataset/9f8ed877-dfd8-43ec-b13d-33c05fb8ba2c/resource/f3608258-555a-45e4-84ac-fcdc731fc469/download/oil_service.json');
            let rawData = await response.text();
            objectData = JSON.parse(rawData);
            console.log(objectData);
            showData('');
        }

        function showData(searchTerm) {
            let result = document.getElementById('result');
            result.innerHTML = ''; // เคลียร์เนื้อหาเก่า

            let totalItems = objectData.features.length;
            let displayedItems = 0; // ตัวแปรเก็บจำนวนข้อมูลที่โชว์ขึ้นมา

            let start = (currentPage - 1) * dataPerPage;
            let end = Math.min(start + dataPerPage, totalItems);

            for (let i = start; i < end; i++) {
                if (objectData.features[i].properties.dcode < 100000) {
                    let content = "สถานีบริการ: " + objectData.features[i].properties.name + " ที่อยู่: " + objectData.features[i].properties.address;
                    content = content.replaceAll("?", " ");

                    if (searchTerm !== '' && !content.toLowerCase().includes(searchTerm.toLowerCase())) {
                        continue; // ไม่ตรงเงื่อนไขการค้นหา
                    }

                    let li = document.createElement('li');
                    li.innerHTML = content;

                    result.appendChild(li);
                    displayedItems++; // เพิ่มจำนวนข้อมูลที่โชว์ขึ้นมา
                }
            }

            if (displayedItems === 0) {
                let li = document.createElement('li');
                li.innerHTML = "ไม่พบข้อมูลที่ตรงกับคำค้นหา";
                result.appendChild(li);
            }

            showPagination(totalItems);
        }

        function showPagination(totalItems) {
            let pagination = document.getElementById('pagination');
            pagination.innerHTML = '';

            if (totalItems > dataPerPage) {
                let totalPages = Math.ceil(totalItems / dataPerPage);

                let prevButton = document.createElement('button');
                prevButton.innerText = 'Previous';
                prevButton.addEventListener('click', function () {
                    if (currentPage > 1) {
                        currentPage--;
                        showData(document.getElementById('search').value);
                    }
                });
                pagination.appendChild(prevButton);

                for (let i = 1; i <= totalPages; i++) {
                    let button = document.createElement('button');
                    button.innerText = i;
                    if (i === currentPage) {
                        button.disabled = true;
                    }
                    button.addEventListener('click', function () {
                        currentPage = i;
                        showData(document.getElementById('search').value);
                    });
                    pagination.appendChild(button);
                }

                let nextButton = document.createElement('button');
                nextButton.innerText = 'Next';
                nextButton.addEventListener('click', function () {
                    if (currentPage < totalPages) {
                        currentPage++;
                        showData(document.getElementById('search').value);
                    }
                });
                pagination.appendChild(nextButton);
            }
        }

        document.getElementById('search').addEventListener('input', function () {
            currentPage = 1;
            if (this.value == '') { showData(this.value); }
            else {
                clear(this.value)
            }

        });

        function clear(searchTerm) {
            let result = document.getElementById('result');
            result.innerHTML = ''; // เคลียร์เนื้อหาเก่า
            let pagination = document.getElementById('pagination');
            pagination.innerHTML = '';
            let totalItems = objectData.features.length;
            let displayedItems = 0
            const po = [];
            for (let i = 0; i < totalItems; i++) {
                // console.log(displayedItems)
                // if (objectData.features[i].properties.dcode < 100000) {
                let content = "สถานีบริการ: " + objectData.features[i].properties.name + " ที่อยู่: " + objectData.features[i].properties.address;
                content = content.replaceAll("?", " ");

                if (searchTerm !== '' && !content.toLowerCase().includes(searchTerm.toLowerCase())) {
                    continue; // ไม่ตรงเงื่อนไขการค้นหา
                }
                po.push(i)
                displayedItems++


            }
            
            show = dataPerPage * (page-1)
            for (let j = 0; j < dataPerPage; j++) {
                console.log(j+show)
                let li = document.createElement('li'); let content = "สถานีบริการ: " + objectData.features[po[j]+show].properties.name + " ที่อยู่: " + objectData.features[po[j]+show].properties.address;
                content = content.replaceAll("?", " ");

               
                li.innerHTML = content;
                result.appendChild(li);
            }
            currentPage = 0
            
            change(po.length)
            

            if (displayedItems === 0) {
                let li = document.createElement('li');
                li.innerHTML = "ไม่พบข้อมูลที่ตรงกับคำค้นหา";
                result.appendChild(li);
            }

        }
        function change(sli) {
            let pagination = document.getElementById('pagination');
            pagination.innerHTML = '';

            if (sli > dataPerPage) {
                let totalpa = Math.ceil(sli / dataPerPage);
                // console.log(totalpa)
                let prevButton = document.createElement('button');
                prevButton.innerText = 'Previous';
                prevButton.addEventListener('click', function () {
                    if (page > 1) {
                        page--;
                        clear(document.getElementById('search').value);
                    }
                });
                pagination.appendChild(prevButton);

                for (let i = 1; i <= totalpa; i++) {
                    let button = document.createElement('button');
                    button.innerText = i;
                    if (i === page) {
                        button.disabled = true;
                    }
                    button.addEventListener('click', function () {
                        page = i;
                        clear(document.getElementById('search').value);
                    });
                    pagination.appendChild(button);
                }

                let nextButton = document.createElement('button');
                nextButton.innerText = 'Next';
                nextButton.addEventListener('click', function () {
                    if (page < totalPages) {
                        page++;
                        showData(document.getElementById('search').value);
                    }
                });
                pagination.appendChild(nextButton);
            }
        }
        getDataFromAPI();
    </script>
</body>

</html>