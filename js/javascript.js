const mainItems = document.querySelectorAll('.main-items');
const homeMineBlokItem = document.querySelectorAll('.home-mine-blok-item');
const loading = document.querySelectorAll('.loading');

function hideTab(params) {
    homeMineBlokItem.forEach((items, index) => {
        items.classList.remove('active');
    });
    mainItems.forEach((items, index) => {
        items.classList.remove('active');
    });
    loading.forEach((item, index) => {
        item.classList.remove('active');
    })
}
function showTab(index) {
    homeMineBlokItem[index].classList.add('active');
    mainItems[index].classList.add('active');
    loading[index].classList.add('active');
}
hideTab();
showTab(0)

mainItems.forEach((item, index) => {
    item.addEventListener('click', () => {
        localStorage.setItem('blok-item', index);
        hideTab();
        showTab(index);
    })
    if (parseInt(localStorage.getItem('blok-item')) == `${index}`) {
        hideTab();
        showTab(index);
    }
})
setInterval(() => {
    loading.forEach((item, index) => {
        item.classList.remove('active');
    })
}, 1500);


const newyersbtnadd = document.querySelector('.newyersbtnadd');
const madalWinndowNewYer = document.querySelector('.madal-winndow-new-yer1');
const exitMadalWindow = document.querySelector('.exit-madal-window')
newyersbtnadd.addEventListener('click', () => {
    madalWinndowNewYer.classList.add('active');
});
exitMadalWindow.addEventListener('click', () => {
    madalWinndowNewYer.classList.remove('active');
});


function madalExit(item) {
    item.classList.remove('active');
}
function madalOpen(item) {
    item.classList.add('active');
}

document.querySelector('.exitMadalGuruh').addEventListener('click', () => {
    madalExit(document.querySelector('.madalGuruh'));
});
document.querySelector('.guruhAdd').addEventListener('click', () => {
    madalOpen(document.querySelector('.madalGuruh'));
})
document.querySelector('.exitMadalGuruhedit').addEventListener('click', () => {
    madalExit(document.querySelector('.madalGuruhEdit'))
});


document.querySelector('.madalStudentEditexit').addEventListener('click', () => {
    madalExit(document.querySelector('.madalStudent'))
});

const madalTeacherEdit = document.querySelector('.madalTeacherEdit');
const editTeacherAbout = document.querySelectorAll('.editTeacherAbout');
const madalTeacherEditexit = document.querySelector('.madalTeacherEditexit');

editTeacherAbout.forEach((item, index) => {
    item.addEventListener('click', () => {
        madalOpen(madalTeacherEdit)
    });
});
// madalTeacherEditexit.addEventListener('click', () => {
//     madalExit(madalTeacherEdit);
// });

const preventDefault1 = document.querySelectorAll('.preventDefault');

preventDefault1.forEach(item =>{
    item.addEventListener('click', (e)=>{
        e.preventDefault();
    })
});

const mainAboutItems = document.querySelectorAll('.main-about-items');
mainAboutItems.forEach((element, index) =>{
    element.addEventListener('click', ()=>{
        hideTab();
        showTab(index+1)
        localStorage.setItem('blok-item', index+1);
    });
    if (parseInt(localStorage.getItem('blok-item')) == `${index+1}`) {
        hideTab();
        showTab(index+1);
    }
})