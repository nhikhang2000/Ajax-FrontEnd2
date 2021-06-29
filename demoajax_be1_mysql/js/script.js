async function getProduct(productId) {
    // Buoc 1:
    const url = "productdetail.php";
    const data = {id: productId}
    const response = await fetch(url, {
        method: "POST",
        headers: {
            'Content-Type': 'application/json;charset=utf-8',
            'Accept': 'application/json;charset=UTF-8'
        },
        body: JSON.stringify(data)
    });

    // Buoc 2:
    const result = await response.json();
    
    // Hien thi giao dien
    const divResult = document.querySelector('.modal-body');
    const title = document.querySelector('.modal-title');

    title.innerHTML = `${result.product_name}`;
    divResult.innerHTML = `<img src='./public/images/${result.product_photo}'class="img-fluid" >
    <p>${result.product_description}</p> 
    <p>Price: ${result.product_price} </p>` ;


    var myModal = new bootstrap.Modal(document.getElementById('productsModal'));
    myModal.show();
}

//Category filter

async function getCategory(categoryID) {
    const url = 'categorydetail.php';
    const data = {id: categoryID};

    const response = await fetch(url, {
        method : "POST",
        headers: {
            'Content-Type': 'application/json;charset=utf-8',
            'Accept': 'application/json;charset=UTF-8'
        },
        body: JSON.stringify(data)
    });

    const result = await response.json();
    const a_img = document.querySelector('.a-img');
    const card_title = document.querySelector('.card-title');
    const card_text = document.querySelector('.card-text');

    
    const arr = [result];
    
    for(let i = 0; i < arr[0].length;i++){
        a_img.innerHTML = `<img src='./public/images/${result[i].product_photo}' style='width: 100%'; >`;
        card_title.innerHTML = `<p>${result[i].product_name}</p>`; 
        card_text.innerHTML = `<p>Price: ${result[i].product_price} </p>` ;
    }
    
}

//
const categoriesCheckbox = document.querySelectorAll('input[name="category-check"]');
let checkedCate = [];
categoriesCheckbox.forEach(checkbox => checkbox.addEventListener('change', function(){

    if(this.checked){
        checkedCate.push(this.value); //them cac value cua cac checkbox vao mang checkcate
    }
    //neu uncheck
    else{
        const valueIndex = checkedCate.indexOf(this.value);
        if(valueIndex !== -1){
            checkedCate.splice(valueIndex, 1);
        }
    }
    getProductByCategory(checkedCate);
}));


async function getProductByCategory(checkedCategories){
    const url = 'categorydetail.php';
    const data = {checkedCategories: checkedCategories};

    const response = await fetch(url, {
        method : "POST",
        headers: {
            'Content-Type': 'application/json;charset=utf-8',
            'Accept': 'application/json;charset=UTF-8'
        },
        body: JSON.stringify(data)
    });
    //b2
    const result = await response.json();
    
    //hien thi giao dien 
    const divResult = document.querySelector('.products-list');
    divResult.innerHTML = '';
    result.forEach(item => {
        divResult.innerHTML += `
        <div class="col-md-4 ">
            <div class="card">
                <a href="#" class="a-img">
                    <img src="./public/images/${item.product_photo}" class="card-img-top" alt="...">
                </a>
                <div class="card-body">
                    <h5 class="card-title" onclick="getProduct(${item.id})">${item.product_name}</h5>
                    <p class="card-text">${item.product_price}</p>
                </div>
            </div>
        </div>
    `;
    })
}

//seach
const searchbox = document.querySelector('#search');
searchbox.addEventListener('keyup', function () {
    searchByKeyword(searchbox.value);
});

async function searchByKeyword(keyword) {
    const url = 'getIdeaSearch.php';
    const data = {keyword: keyword};

    const response = await fetch(url, {
        method : "POST",
        headers: {
            'Content-Type': 'application/json;charset=utf-8',
            'Accept': 'application/json;charset=UTF-8'
        },
        body: JSON.stringify(data)
    });

    const result = await response.json();

    const divResult = document.querySelector('#show-list');
    divResult.innerHTML = '';
    result.forEach(item => {
        let keyWordReg = new RegExp(keyword,"gi");
        let productName = item.product_name.replace(keyWordReg, `<b>${keyword}</b>`);
        divResult.innerHTML += `
        <div class=' list-group-item list-group-item-action border-1'>
            <div class="row">
                <div class="col-md-9">
                    <a href='product.php/-${item.id}'>${productName}</a>
                </div>
                <div class="col-md-3">
                    <img class='img-fluid' src='./public/images/${item.product_photo}'>
                </div>
            </div>
       </div>
        `;
    })
}

const loadmore = document.querySelector(".load-more");
let currentPage = 2;
let perPage = 3;
loadmore.addEventListener('click', function () {
    loadMorePage(perPage,currentPage);
    currentPage++;
    if(currentPage>perPage){
        loadmore.style.display = 'none';
    }
    
})

//Load more
async function loadMorePage(perPage,page) {
    
    const spinner_border = document.querySelector(".spinner-border");
    spinner_border.style.visibility = 'visible';
    

    const url = 'loadmorepage.php';
    const data = {perPage: perPage,page: page};

    const response = await fetch(url, {
        method : "POST",
        headers: {
            'Content-Type': 'application/json;charset=utf-8',
            'Accept': 'application/json;charset=UTF-8'
        },
        body: JSON.stringify(data)
    });
    const result = await response.json();
    spinner_border.style.visibility = 'hidden';

    const divResult = document.querySelector('.products-list');
    result.forEach(item => {
        divResult.innerHTML += `
        <div class="col-md-4 ">
            <div class="card">
                <a href="product.php/-${item.id}" class="a-img">
                    <img src="./public/images/${item.product_photo}" class="card-img-top" alt="...">
                </a>
                <div class="card-body">
                    <h5 class="card-title" onclick="getProduct(${item.id})">${item.product_name}</h5>
                    <div class="" style="font-size: 13px;">
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>          
                    <div class="row price-media">
                        <div class="col-md-7">
                        <p class="card-text">${item.product_price} VND</p>
                        </div>
                        <div class="col-md-5">
                            <div class="interactive">
                                <a class="cmt" href="product.php/-${item.id}"><i class="far fa-comment-dots"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    });
};

