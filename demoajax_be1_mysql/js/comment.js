const submit = document.querySelector('#submit');
submit.addEventListener('click', () =>{
    const id_pro = document.querySelector("#product_id");
    const comment = document.querySelector("#comment");
    const name = document.querySelector("#name_comment");

    AddComment(comment.value,id_pro.value,name.value);
});
// comment
async function AddComment(comment,id, name_comment) {
    let today = new Date();
    //let date = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();
    let date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    const dateTime = date;
    //Buoc 1:
    const url = "../AddComments.php";
    const data = {comment: comment, id: id, name_comment: name_comment }
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
    const divResult = document.querySelector('#show-comment');
    divResult.innerHTML += `
        <div class='show'>
            <div class='show-name'>
                <p>By <b>${name_comment}</b> on <i>${dateTime}</i></p>
            </div>
            <div class='show-content'>
                <p>${comment}</p>
            </div>
        </div>
        `;
      
};


