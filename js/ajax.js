$(document).ready(function () {
    const url = "http://localhost/bekend/kocka_admin/server.php"
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
                    let activeYears = '';
                    (value.active === 'true') ? activeYears = 'checked' : activeYears = '';
                    $('.newYersid').append(`
                            <div class="newYers-item">
                                <p>
                                    ${value.name}
                                </p>
                                <div>
                                    <input id="yearsActive" value="${value.id}" type="checkbox" ${activeYears} style="margin-right:5px" class="form-check-input">
                                    <button style="color:aqua" id="edit_new-yer" value="${value.id}" class="preventDefault" ><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button style="color:red" id="deleteYears" value="${value.id}" class="deleteYears"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </div>       
                    `)
                });

            }
        });
    }
    fetchData();

    $('.newYersid').on('click', '#yearsActive', (e) => {
        $target = e.target.checked;
        $id = e.target.value;


        e.preventDefault();
        $.ajax({
            url: `${url}?action=UpdateYearsTarget`,
            type: "GET",
            data: {
                id: $id,
                name: $target,
            },
            success: function (data) {
                let updateYearsTarget = JSON.parse(data);
                if (updateYearsTarget.status == 200) {
                    fetchData();
                    modal(updateYearsTarget.message, 'success');
                }
                else if (updateYearsTarget.status == 400) {
                    modal(updateYearsTarget.message, 'error');
                }
                else if (updateYearsTarget.status == 500) {
                    modal(updateYearsTarget.message, 'error');
                }
            }
        });
    });

    // yangi oquv yili qoshish
    $('#yearAddBtn').on('click', (e) => {
        e.preventDefault();
        $.ajax({
            data: {
                name: $('#yearsAddInput').val(),
                active: 'false',
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

    function fetchDataAddYearsClass(id, action) {
        $.ajax({
            url: `${url}?action=${action}`,
            type: "GET",
            dataType: "json",
            success: function (response) {
                let data = response.data;
                $(id).empty();
                $.each(data, function (index, value) {
                    $(id).append(`
                        <option value="${value.id}">${value.name}</option>
                    `)
                });
            }
        });
    }

    fetchDataAddYearsClass('#classStatistikaData', 'fetchDataClassNameStatistik');



    function fetchDataAddYearsClassName(id, action) {
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

    function fetchDataAddYearsTeachers(id, action) {
        $.ajax({
            url: `${url}?action=${action}`,
            type: "GET",
            dataType: "json",
            success: function (response) {
                let data = response.data;
                $(id).empty();
                $.each(data, function (index, value) {
                    $(id).append(`
                        <option value="${value.id}">${value.ism} ${value.fam}</option>
                    `)
                });
            }
        });
    }
    fetchDataAddYearsTeachers('#teachersClassAddId2', 'fetchDataClassName2');

    $('.addClassModalActiveJq').on('click', () => {
        fetchDataAddYearsClass('#addClassReady', 'fetchDataClassReadyYearsName');
        fetchDataAddYearsClassName('#studentSelect', 'fetchDataClassName');
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
                                    <span>Guruh: ${value.guruh_name}</span>
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

    fetchDataAddYearsClassName('#studentSelect', 'fetchDataClassName');



    fetchDataAddYearsClass('#teachersClassAddId', 'fetchDataTeachersName');

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
                fetchDataAddYearsClassName('#studentDataEditClass', 'fetchDataStudentClassReadyName');
            }
        })

    });

    // malumotlarni ozgartrish
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
                let updateStudents = JSON.parse(data);
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


    function profileEdit() {
        $.ajax({
            data: { id: 1 },
            type: "GET",
            url: `${url}?action=profileEdit`,
            dataType: "json",
            success: function (response) {
                let profileData = response.data;
                $('#profileIsm').val(profileData.ism),
                    $('#profileFam').val(profileData.fam),
                    $('#profileTel').val(profileData.tel),
                    $('#profileLogin').val(profileData.login),
                    $('#profileParol').val(profileData.parol)
            }
        })
    }
    profileEdit();

    // profile malumotlarni ozgartrish
    $('#profileEditBtn').on('click', (e) => {
        e.preventDefault();
        $.ajax({
            url: `${url}?action=UpdateProfile`,
            type: "GET",
            data: {
                id: 1,
                ism: $('#profileIsm').val(),
                fam: $('#profileFam').val(),
                tel: $('#profileTel').val(),
                login: $('#profileLogin').val(),
                parol: $('#profileParol').val()
            },
            success: function (data) {
                let updateProfile = JSON.parse(data);
                if (updateProfile.status == 200) {
                    modal(updateProfile.message, 'success');
                }
                else if (updateProfile.status == 400) {
                    modal(updateProfile.message, 'error');
                }
                else if (updateProfile.status == 500) {
                    modal(updateProfile.message, 'error');
                }
            }
        });
    });




    // oqtuvchilar bilan ishlash

    // oqib olish uchun
    function fetchDataTeachers() {
        $.ajax({
            url: `${url}?action=fetchDataTeachersReady`,
            type: "GET",
            dataType: "json",
            success: function (response) {
                let dataTeacher = response.data;

                $('#teachersList').empty();
                $.each(dataTeacher, function (index, value) {
                    $('#teachersList').append(`
                        <li>
                            <div>
                                <p>${value.ism} ${value.fam}</p>
                                <p>
                                    <span>Tel: ${value.tel}</span>
                                    <span>Login: ${value.login}</span>
                                    <span>Parol: ${value.parol}</span>
                                    <span>Guruhlar: ${value.groups} </span>
                                    <span>O'quv yili: ${value.year_name} </span>
                                </p>
                            </div>
                            <div class="studentEditDelete">
                                <!-- <button class="editTeacherAbout"><i class="fa-solid fa-pen-to-square"></i></button> -->
                                <button id="teacherDelete" value="${value.id}"><i style='color:red' class="fa-solid fa-trash"></i></button>
                            </div>
                        </li>  
                    `)
                });

            }
        });
    }

    fetchDataTeachers();


    // qoshish
    $('#addTeacher').on('click', (e) => {
        e.preventDefault();
        $.ajax({
            data: {
                ism: $('#teacherName').val(),
                fam: $('#teacherFam').val(),
                tel: $('#teacherTel').val(),
                login: $('#login').val(),
                parol: $('#parol').val(),
            },
            url: `${url}?action=teachersAdd`,
            type: "GET",
            success: function (data) {
                let studentsData = JSON.parse(data);
                console.log(studentsData);
                if (studentsData.status == 200) {
                    fetchDataTeachers();
                    fetchDataAddYearsTeachers('#teachersClassAddId2', 'fetchDataClassName2');
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


    //o'qtuvchini o'chirish
    $('#teachersList').on('click', '#teacherDelete', (e) => {
        id = e.currentTarget.attributes.value.value;
        $.ajax({
            data: { id: id, },
            type: "GET",
            url: `${url}?action=delateTeachers`,
            success: function (data) {
                let dataDeleteTeachers = JSON.parse(data);
                if (dataDeleteTeachers.status == 200) {
                    fetchDataTeachers();
                    modal(dataDeleteTeachers.message, 'error');
                }
                else if (dataDelete.status == 500) {
                    madal(dataDeleteTeachers.message, 'error')
                }
            }
        })

    });

    // oqtuvchini guruhga biriktrish 
    $('#classAddTeachers').on('click', (e) => {
        e.preventDefault();
        $.ajax({
            data: {
                guruhId: $('#teachersClassAddId').val(),
                teachersId: $('#teachersClassAddId2').val(),
            },
            url: `${url}?action=teachersAddClass`,
            type: "GET",
            success: function (data) {
                let teachersData = JSON.parse(data);
                if (teachersData.status == 200) {
                    fetchDataTeachers();
                    modal(teachersData.message, 'success');
                    $('#teacherName').val('')
                    $('#teacherFam').val('')
                    $('#teacherTel').val('')
                    $('#login').val('')
                    $('#parol').val('')
                }
                else if (teachersData.status == 500) {
                    modal(teachersData.message, 'error');
                }
                else if (teachersData.status == 400) {
                    modal(teachersData.message, 'error');
                }

            }
        });
    });



    //Statistika


    const result = {};
    $('#statistikAdd').on('click', (e) => {
        e.preventDefault();
        for (var key in result) {
            if (result.hasOwnProperty(key)) {
                delete result[key];
            }
        }
        $.ajax({
            data: {
                classId: $('#classStatistikaData').val(),
                date: $('#dateStatistikaData').val(),
            },
            type: "GET",
            url: `${url}?action=StatistikData`,
            dataType: "json",
            success: function (response) {
                response.data.forEach((element) => {
                    const list = result[element.id]?.list || [];
                    list.push({
                        lesson: element.lesson,
                        title: element.title,
                        teacher_ism: element.teacher_ism
                    });
                    result[element.id] = {
                        id: element.id,
                        talaba_ism: element.talaba_ismi,
                        talaba_fam: element.talaba_fam,
                        guruh_name: element.guruh_name,
                        date: element.date,
                        list: list
                    };
                });


                if (Object.keys(result).length != 0) {
                    $('.madalChatInformatio').removeClass('active');
                    $('.madalChatStudentInformation').addClass('active');
                    $('#statisticDataAll').empty();
                    Object.keys(result).forEach((key, index) => {
                        teacherName = result[key].list[0] && result[key].list[0].teacher_ism ? result[key].list[0].teacher_ism : 'none'
                        teacherName1 = result[key].list[1] && result[key].list[1].teacher_ism ? result[key].list[1].teacher_ism : 'none'
                        teacherName2 = result[key].list[2] && result[key].list[2].teacher_ism ? result[key].list[2].teacher_ism : 'none'
                        teacherName3 = result[key].list[3] && result[key].list[3].teacher_ism ? result[key].list[3].teacher_ism : 'none'
                    })



                    $('#statisticDataAll').append(`
                            <li class="firstUser">
                                <p>№</p>
                                <p>Fish</p>
                                <p>1-para <span>${teacherName}</span></p>
                                <p>2-para <span>${teacherName1}</span></p>
                                <p>3-para <span>${teacherName2}</span></p>
                                <p>4-para <span>${teacherName3}</span></p>
                                <p>Kun davomida</p>
                            </li>
                    `);



                    Object.keys(result).forEach((key, index) => {
                        let count = 0, countString = 0;
                        result[key].list.forEach(item => {
                            if (item.title === "2" || item.title === " 2") {
                                count++; // Agar title "2" bo'lsa, hisoblagichni oshirish
                            }
                            else if (item.title === 's' || item.title === ' s') {
                                countString++
                            }
                        });

                        $('#statisticDataAll').append(`
                            
                            <li>
                                <p>${index + 1}</p>
                                <p class="studetName">${result[key].talaba_fam} ${result[key].talaba_ism}</p>
                                <p>${result[key].list[0] && result[key].list[0].title ? result[key].list[0].title : 'none'}</p>
                                <p>${result[key].list[1] && result[key].list[1].title ? result[key].list[1].title : 'none'}</p>
                                <p>${result[key].list[2] && result[key].list[2].title ? result[key].list[2].title : 'none'}</p>
                                <p>${result[key].list[3] && result[key].list[3].title ? result[key].list[3].title : 'none'}</p>
                                <p> 
                                    <span style="color:red;font-weight: bold;">${count * 2}</span>/
                                    <span style="color:lime;font-weight: bold;">${countString * 2}</span>
                                </p>
                            </li>
                        `);
                    });
                }
                else {
                    $('.madalChatInformatio').addClass('active');
                    $('.madalChatStudentInformation').removeClass('active');
                    modal("Ma'lumot topilmadi🤨", 'error')
                }



            }
        })

    });



    $('#exelgaexport').on('click', (e) => {
        e.preventDefault();
        // Excel jadvalini yaratish
        var ws_data = [
            ["Guruh:", result["21"].guruh_name], // Guruh nomi
            ["Sana:", result["21"].date],        // Sana
            ["ID", "Ism Familiya", "1-para", "2-para", "3-para", "4-para"] // Ustunlar sarlavhasi
        ];

        // Har bir talabaning ma'lumotlarini jadvalga qo'shish
        Object.keys(result).forEach(function (key) {
            var student = result[key];
            var row = [
                student.id,
                student.talaba_ism + " " + student.talaba_fam, // Ism va familiya birlashtiriladi
                (student.list[0] && student.list[0].title.trim() === "") ? "" : (student.list[0] ? student.list[0].title.trim() : "none"), // 1-para
                (student.list[1] && student.list[1].title.trim() === "") ? "" : (student.list[1] ? student.list[1].title.trim() : "none"), // 2-para
                (student.list[2] && student.list[2].title.trim() === "") ? "" : (student.list[2] ? student.list[2].title.trim() : "none"), // 3-para
                (student.list[3] && student.list[3].title.trim() === "") ? "" : (student.list[3] ? student.list[3].title.trim() : "none")  // 4-para
            ];

            // Agar barcha para ma'lumotlari bo'sh bo'lsa, barcha ustunlar 'none' bo'lsin
            if (row[2] === "none" && row[3] === "none" && row[4] === "none" && row[5] === "none") {
                row[2] = "none";
                row[3] = "none";
                row[4] = "none";
                row[5] = "none";
            }

            ws_data.push(row);
        });

        // Excel jadvalini yaratish
        var ws = XLSX.utils.aoa_to_sheet(ws_data);

        // Ustunlarni birlashtirish (ixtiyoriy)
        ws['!merges'] = [
            { s: { r: 0, c: 0 }, e: { r: 0, c: 5 } }, // Guruh nomi ustunlarni birlashtirish
            { s: { r: 1, c: 0 }, e: { r: 1, c: 5 } }  // Sana ustunlarni birlashtirish
        ];

        // Ustun kengliklari (ixtiyoriy)
        ws['!cols'] = [
            { wch: 5 },    // ID
            { wch: 20 },   // Ism Familiya
            { wch: 10 },   // 1-para
            { wch: 10 },   // 2-para
            { wch: 10 },   // 3-para
            { wch: 10 }    // 4-para
        ];

        // Yangi Excel kitobi yaratish
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "O'quvchilar");

        // Excel faylni yuklab olish
        XLSX.writeFile(wb, "oqtuvchi_hisoboti.xlsx");

    });



    // Bugungi sanani olish
    const today = new Date();
    const currentDate = today;

    // Sanani ko'rsatish
    function updateDateDisplay() {
        const day = currentDate.getDate();
        const month = currentDate.getMonth() + 1; // JavaScriptda oylar 0 dan boshlanadi
        const year = currentDate.getFullYear();
        const formattedDate = year + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
        $('#todayId').text(formattedDate);
    }

    // Sanani yangilash
    updateDateDisplay();

    function fetchDataTeachersActive(date) {
        $.ajax({
            url: `${url}?action=fetchDataTeachersReadyActive`,
            type: "GET",
            dataType: "json",
            data: {
                todayDate: date
            },
            success: function (response) {
                let dataTeacherActive = response.data;

                $('#teacherListActive').empty();
                $('#teacherListActive').append(`
                            <li class="chatStatisticInformationItems">
                                <p>№</p>
                                <p>FISH</p>
                                <p>Activligi</p>
                            </li>
                        `);
                $.each(dataTeacherActive, function (index, value) {
                    $('#teacherListActive').append(`
                            <li>
                                <p>${index+1}</p>
                                <p class="itemsChat">${value.ism} ${value.fam}</p>
                                <p>${value.title_count*2}</p>
                            </li>
                    `)
                });

            }
        });
    }
    fetchDataTeachersActive('2024-10-14')
    


    // Tugmalarni bosish funksiyalari
    $('#prevDate').click(function (e) {
        e.preventDefault();
        currentDate.setDate(currentDate.getDate() - 1); // Orqaga bir kun o'tkazish
        updateDateDisplay();
        fetchDataTeachersActive($('#todayId').text())
    });

    $('#nextDate').click(function (e) {
        e.preventDefault();
        currentDate.setDate(currentDate.getDate() + 1); // Oldinga bir kun o'tkazish
        updateDateDisplay();
        fetchDataTeachersActive($('#todayId').text())
    });



});
