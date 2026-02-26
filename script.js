document.addEventListener('DOMContentLoaded', () => {
    const productContainers = [...document.querySelectorAll('.product-container')];
    const nxtBtn = [...document.querySelectorAll('.nxt-btn')];
    const preBtn = [...document.querySelectorAll('.pre-btn')];

    productContainers.forEach((item, i) => {
        let containerDimensions = item.getBoundingClientRect();
        let containerWidth = containerDimensions.width;

        nxtBtn[i].addEventListener('click', () => {
            item.scrollLeft += containerWidth;
        });

        preBtn[i].addEventListener('click', () => {
            item.scrollLeft -= containerWidth;
        });
    });
});


let toggle=document.getElementById('toggle');
let label_toggle=document.getElementById('label_toggle')
toggle.addEventListener('change',(event)=>{
    let checked=event.target.checked;
    document.body.classList.toggle('dark');
    if(checked==true){
        label_toggle.innerHTML='<i class="fa-solid fa-circle-half-stroke"></i>';
        label_toggle.style.color="black";
    }
    else{
                label_toggle.innerHTML='<i class="fa-solid fa-moon"></i>';
        label_toggle.style.color="yellow";

    }


})