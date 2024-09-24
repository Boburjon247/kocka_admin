$(document).ready(function () {
    function modal(data, situation) {
        $('.madal_main').empty();
        $('.madal_main').addClass('active')
        $('.madal_main').addClass(`${situation}`);
        $('.madal_main').append(`
            <p>${data}</p>   
        `);
        setInterval(() => {
            $('.madal_main').removeClass('active');
            $('.madal_main').removeClass(`${situation}`);

        }, 4500);

    }

    const url = "http://localhost/bekend/kocka_admin/server.php"
    // fetchData yillarni oqib olish uchun
    function fetchData() {
        $.ajax({
            url: `${url}?action=fetchDataYearsReady`,
            type: "GET",
            dataType: "json",
            success: function (response) {
                let data = response.data;
                $('.newYersid').empty();
                $.each(data, function (index, value) {
                    $('.newYersid').append(`
                            <div class="newYers-item">
                                <p>
                                    ${value.name}
                                </p>
                                <div>
                                    <button id="edit_new-yer" value="${value.id}" class="preventDefault" ><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button id="deleteYears" value="${value.id}" class="deleteYears"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </div>       
                    `)
                });

            }
        });
    }
    fetchData();

    // yangi oquv yili qoshish
    $('#yearAddBtn').on('click', (e) => {
        e.preventDefault();
        $.ajax({
            data: {
                name: $('#yearsAddInput').val()
            },
            url: `${url}?action=insertYears`,
            type: "GET",
            success: function (data) {
                let data1 = JSON.parse(data);
                if (data1.status == 200) {
                    fetchData();
                    $('.madal-winndow-new-yer1').removeClass('active');
                    $('#yearsAddInput').val(' ')
                    modal(data1.message, 'success');
                }
                else if (data1.status == 500) {
                    fetchData();
                    $('.madal-winndow-new-yer1').removeClass('active');
                    modal(data1.message, 'error');
                }
                else if (data1.status == 400) {
                    modal(data1.message, 'error');
                }
            }
        });
    });


    // oquv yilini ochirish
    $('.newYersid').on('click', '#deleteYears', (e) => {
        id = e.currentTarget.attributes.value.value;
        $.ajax({
            data: { id: id, },
            type: "GET",
            url: `${url}?action=delateYears`,
            success: function (data) {
                let dataDelete = JSON.parse(data);
                if (dataDelete.status == 200) {
                    fetchData();
                    modal(dataDelete.message, 'error');
                }
                else if (dataDelete.status == 500) {
                    madal(dataDelete.message, 'error')
                }
            }
        })
    });


    // oquv yilini yangilash

    // madal oynani ochish
    $('.newYersid').on('click', '#edit_new-yer', (e) => {
        id = e.currentTarget.attributes.value.value;
        $('.madal-winndow-edit-yer').addClass('active');
        $.ajax({
            data: { id: id },
            type: "GET",
            url: `${url}?action=editReadyYears`,
            dataType: "json",
            success: function (response) {
                let yearsReadyData = response.data;
                $('#inputEditDataYears').val(yearsReadyData.name)
            }
        })

    });

    $('#btnUpdataYearsId').on('click', (e) => {
        e.preventDefault();
        $.ajax({
            url: `${url}?action=UpdateYears`,
            type: "GET",
            data: {
                id: id,
                name: $('#inputEditDataYears').val()
            },
            success: function (data) {
                let updateYears = JSON.parse(data);
                if (updateYears.status == 200) {
                    fetchData();
                    modal(updateYears.message, 'success');
                    $('.madal-winndow-edit-yer').removeClass('active');
                }
                else if (data1.status == 400) {
                    modal(updateYears.message, 'error');
                }
                else if (data1.status == 500) {
                    modal(updateYears.message, 'error');
                }
            }
        });
    });

    // madal oynani yopish;
    $('.exit-madal-window-edit').on('click', () => {
        $('.madal-winndow-edit-yer').removeClass('active');
    });



    // guruhlar oqib olish
    function fetchDataClass() {
        $.ajax({
            url: `${url}?action=fetchDataClassReady`,
            type: "GET",
            dataType: "json",
            success: function (response) {
                let data = response.data;
                $('.newClassBlock').empty();
                $.each(data, function (index, value) {
                    $('.newClassBlock').append(`
                        <div class="newYers-item">
                            <p>
                                 ${value.name} <br>
                                 <span style="font-size:14px;">${value.year_name}</span>
                            </p>
                            <div>
                                <button id="editClassName" value="${value.id}"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button id="classDeleteId" value="${value.id}"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>    
                    `)
                });
            }
        });
    }

    fetchDataClass();


    // guruh yaratishda oquv yilini oqib olish uchun 

    function fetchDataAddYearsClass(id,action) {
        $.ajax({
            url: `${url}?action=${action}`,
            type: "GET",
            dataType: "json",
            success: function (response) {
                let data = response.data;
                $(id).empty();
                $.each(data, function (index, value) {
                    $(id).append(`
                        <option value="${value.name}">${value.name}</option>
                    `)
                });
            }
        });
    }

    $('.addClassModalActiveJq').on('click', () => {
        fetchDataAddYearsClass('#addClassReady','fetchDataClassReadyYearsName');
        fetchDataAddYearsClass('#studentSelect', 'fetchDataClassName');
    });


    // yangi guruh qoshihs uchun
    $('#addClassDb').on('click', (e) => {
        e.preventDefault();
        $.ajax({
            data: {
                className: $('#classNameInput').val(),
                yearsName: $('#addClassReady').val()
            },
            url: `${url}?action=insertClassName`,
            type: "GET",
            success: function (data) {
                let classData = JSON.parse(data);
                if (classData.status == 200) {
                    fetchDataClass();
                    $('#classNameInput').val(' ');
                    $('.madalGuruh').removeClass('active');
                    modal(classData.message, 'success');
                }
                else if (classData.status == 500) {
                    modal(classData.message, 'error');
                }
                else if (classData.status == 400) {
                    modal(classData.message, 'error');
                }

            }
        });
    });

    //guruhni o'chirish
    $('.newClassBlock').on('click', '#classDeleteId', (e) => {
        id = e.currentTarget.attributes.value.value;
        $.ajax({
            data: { id: id, },
            type: "GET",
            url: `${url}?action=delateClass`,
            success: function (data) {
                let dataDeleteClass = JSON.parse(data);
                if (dataDeleteClass.status == 200) {
                    fetchDataClass();
                    modal(dataDeleteClass.message, 'error');
                }
                else if (dataDelete.status == 500) {
                    madal(dataDeleteClass.message, 'error')
                }
            }
        })
    });

    // guruh malumotlarni yangilash uchun

    // oqib olish uchun
    $('.newClassBlock').on('click', '#editClassName', (e) => {
        id = e.currentTarget.attributes.value.value;
        $('.madalGuruhEdit').addClass('active');
        $.ajax({
            data: { id: id },
            type: "GET",
            url: `${url}?action=editReadyClass`,
            dataType: "json",
            success: function (response) {
                let classReadyData = response.data;
                $('#classNameEditInput').val(classReadyData.name);
                fetchDataAddYearsClass('#classNameEditSelect', 'fetchDataClassReadyYearsName');
            }
        })

    });

    $('#editClassData').on('click', (e) => {
        e.preventDefault();
        $.ajax({
            url: `${url}?action=UpdateClass`,
            type: "GET",
            data: {
                id: id,
                name: $('#classNameEditInput').val(),
                nameYear: $('#classNameEditSelect').val(),
            },
            success: function (data) {
                let updateClass = JSON.parse(data);
                if (updateClass.status == 200) {
                    fetchDataClass();
                    modal(updateClass.message, 'success');
                    $('.madalGuruhEdit').removeClass('active');
                }
                else if (updateClass.status == 400) {
                    modal(updateClass.message, 'error');
                }
                else if (updateClass.status == 500) {
                    modal(updateClass.message, 'error');
                }
            }
        });
    });



    // oquvchilar bilan ishlash
    
    // oquvchilar malumotlarni oqib olish
    function fetchDataStudents() {
        $.ajax({
            url: `${url}?action=fetchDataStudentsReady`,
            type: "GET",
            dataType: "json",
            success: function (response) {
                let data = response.data;
                $('#studentsIdItem').empty();
                $.each(data, function (index, value) {
                    $('#studentsIdItem').append(`
                        <li>
                            <div>
                                <p>${value.ism} ${value.fam}</p>
                                <p>
                                    <span>Talaba: ${value.tel}</span>
                                    <span>Talaba Uy: ${value.uy_tel}</span>
                                    <span>Guruh: ${value.guruh_name }</span>
                                </p>
                            </div>
                            <div class="studentEditDelete">
                                <button id="editModalAdd" value="${value.id}"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button id="deleteStudents" value="${value.id}" ><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </li>    
                    `)
                });

            }
        });
    }
    fetchDataStudents();

    // oquvchini ochirish
    $('#studentsIdItem').on('click', '#deleteStudents', (e) => {
        id = e.currentTarget.attributes.value.value;        
        $.ajax({
            data: { id: id, },
            type: "GET",
            url: `${url}?action=delateStudents`,
            success: function (data) {
                let dataDeleteClass = JSON.parse(data);
                if (dataDeleteClass.status == 200) {
                    fetchDataStudents();
                    modal(dataDeleteClass.message, 'error');
                }
                else if (dataDelete.status == 500) {
                    madal(dataDeleteClass.message, 'error')
                }
            }
        })
    });

    // yangi student qoshish uchun

    $('#addStudents').on('click', (e) => {
        e.preventDefault();                
        $.ajax({
            data: {
                ism: $('#studentName').val(),
                fam: $('#studentFam').val(),
                tel: $('#studentTel').val(),
                uy_tel: $('#studentTelUy').val(),
                guruh_name: $('#studentSelect').val(),
            },
            url: `${url}?action=studentsClassName`,
            type: "GET",
            success: function (data) {
                let studentsData = JSON.parse(data);
                if (studentsData.status == 200) {
                    fetchDataStudents();
                    modal(studentsData.message, 'success');
                }
                else if (studentsData.status == 500) {
                    modal(studentsData.message, 'error');
                }
                else if (studentsData.status == 400) {
                    modal(studentsData.message, 'error');
                }

            }
        });
    });
    fetchDataAddYearsClass('#studentSelect', 'fetchDataClassName');

    // malumotni ozgartirish uchun oqib olish
    $('#studentsIdItem').on('click', '#editModalAdd', (e) => {
        id = e.currentTarget.attributes.value.value;
        $('.madalStudent').addClass('active');        
        $.ajax({
            data: { id: id },
            type: "GET",
            url: `${url}?action=editReadyStudents`,
            dataType: "json",
            success: function (response) {
                let classReadyData = response.data;
                $('#sIsm').val(classReadyData.ism);
                $('#sFam').val(classReadyData.fam);
                $('#sTel').val(classReadyData.tel);
                $('#sUyTel').val(classReadyData.uy_tel);
                fetchDataAddYearsClass('#studentDataEditClass', 'fetchDataStudentClassReadyName');
            }
        })

    });

    $('#studentDataEditDataDb').on('click', (e) => {
        e.preventDefault();  
        $.ajax({
            url: `${url}?action=UpdateStudents`,
            type: "GET",
            data: {
                id: id,
                ism: $('#sIsm').val(),
                fam: $('#sFam').val(),
                tel: $('#sTel').val(),
                uy_tel: $('#sUyTel').val(),
                guruh_name: $('#studentDataEditClass').val()
            },
            success: function (data) {
                let updateStudents= JSON.parse(data);                
                if (updateStudents.status == 200) {
                    fetchDataStudents()
                    modal(updateStudents.message, 'success');
                    $('.madalStudent').removeClass('active');
                }
                else if (updateStudents.status == 400) {
                    modal(updateStudents.message, 'error');
                }
                else if (updateStudents.status == 500) {
                    modal(updateStudents.message, 'error');
                }
            }
        });
    });


    


    
    













});