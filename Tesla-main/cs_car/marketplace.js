function searchPosts() {
  const input = document.getElementById("searchInput");
  const filter = input.value;

  // สร้าง XMLHttpRequest object
  const xhr = new XMLHttpRequest();

  // กำหนดฟังก์ชันที่จะทำงานเมื่อมีการอัพเดตข้อมูล
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      const postContainer = document.querySelector(".post_container");
      postContainer.innerHTML = ""; // ล้างเนื้อหาปัจจุบัน

// ...
if (response.length > 0) {
  response.forEach(function (post) {
    // สร้าง HTML เพื่อแสดงข้อมูลโพสต์
    const postItem = document.createElement("div");
    postItem.classList.add("post_item");

    // สร้าง HTML สำหรับแสดงลิงก์ (a) เพื่อลิงก์ไปยังรายละเอียดโพสต์
    const postLink = document.createElement("a");
    postLink.href = "marketplace_postdetail.php?post_id=" + post.post_id;

    //แสดงรูปภาพ (ต้องตรวจสอบว่ามีรูปหรือไม่)
    if (post.photo_name) {
      const postPhoto = document.createElement("div");
      postPhoto.classList.add("post_photo");

      const postPhotoImage = document.createElement("img");
      postPhotoImage.src = "uploads/" + post.photo_name;
      postPhotoImage.alt = "รูปภาพ";
      postPhotoImage.width = "200";
      postPhotoImage.height = "200";

      postPhoto.appendChild(postPhotoImage);
      postLink.appendChild(postPhoto);
    }

    //แสดงหัวข้อ, เนื้อหา, วันที่โพสต์, ผู้โพสต์
    const postDetail = document.createElement("div");
    postDetail.classList.add("post_detail");

    const postHeader = document.createElement("h1");
    postHeader.textContent = post.header;

    const postContent = document.createElement("h3");
    postContent.textContent = post.detail;

    const postDate = document.createElement("p");
    postDate.textContent = "โพสต์เมื่อ: " + post.post_dated;

    const postAuthor = document.createElement("p");
    postAuthor.textContent = "โพสต์โดย: " + post.firstname;

    postDetail.appendChild(postHeader);
    postDetail.appendChild(postContent);
    postDetail.appendChild(postDate);
    postDetail.appendChild(postAuthor);

    postLink.appendChild(postDetail);
    postItem.appendChild(postLink);

    postContainer.appendChild(postItem);
  });
} else {
  
  postContainer.innerHTML = "ไม่พบผลลัพธ์";
}

// ...

    }
  };

  
  xhr.open("GET", "search.php?search=" + filter, true);
  xhr.send();
}
