$(document).ready(function () {
    const url = "http://localhost/bekend/kocka_admin/server.php";

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

    // oquv vilini option ga oqib olish
    function fetchDataAddYearsClass(idValue, action) {
        $.ajax({
            url: `${url}?action=${action}`,
            type: "GET",
            dataType: "json",
            success: function (response) {
                let data = response.data;
                $(idValue).empty();
                $.each(data, function (index, value) {
                    $(idValue).append(`
                        <option value="${value.name}">${value.name}</option>
                    `)
                });
            }
        });
    }


    fetchDataAddYearsClass('#teacherPageYearsId', 'yearsReadyTeacherPage');

    function fetchDataAddClass(idValue, action) {
        $.ajax({
            url: `${url}?action=${action}`,
            data: {
                id: $('#teacherIdPage').val()
            },
            type: "GET",
            dataType: "json",
            success: function (response) {
                let data = response.data;
                $(idValue).empty();
                $.each(data, function (index, value) {
                    $(idValue).append(`
                        <option value="${value.name}" name="${value.id}">
                            ${value.name}
                        </option>
                    `)
                });
            }
        });
    }

    fetchDataAddClass('#teacherPageClassId', 'ClassReadyTeacherPage');

    

    $('#teacherTableAddData').on('click', (e) => {
        e.preventDefault();
        

        const todayDate = new Date();
        const sanaFormat = todayDate.getFullYear() + "-" +
            ("0" + (todayDate.getMonth() + 1)).slice(-2) + "-" +
            ("0" + todayDate.getDate()).slice(-2);

        if (sanaFormat == $('#todayDateJs').val()) {
            $.ajax({
                url: `${url}?action=studetsDataTeachers`,
                data: {
                    className_n1: $('#teacherPageClassId').val(),
                },
                type: "GET",
                dataType: "json",
                success: function (response) {
                    let data = response.data;
                    if ($('#todayDateJs').val() == sanaFormat) {

                        $('.teacherControlButton2').addClass('btnTeachers');

                        $('#teacherPageDataStudentsItems').empty();
                        $('#teacherPageDataStudentsItems').append(`
                             <li class="information-students-items">
                                <p>№</p>
                                <p>FISH</p>
                                <p>Active</p>
                            </li>
                        `);
                        let dataFilterA_Z = data.sort(function (a, b) {
                            return a.ism.localeCompare(b.ism);
                        })
                        $.each(dataFilterA_Z, function (index, value) {

                            $('#teacherPageDataStudentsItems').append(`
                            <li>
                                
                                <p>
                                    <input type="hidden" class="studentGreatID" value="${value.id}">
                                    ${index + 1}
                                </p>
                                <p>${value.ism} ${value.fam}</p>
                                <p>
                                    <input class="studentGreatClassIdGrate" maxlength="1" type="text" oninput="this.value = this.value.replace(/[^2s]/g, '');" />
                                </p>
                            </li>     
                        `)
                        });
                    }
                    else if ($('#todayDateJs').val() == '') {
                        modal("Sana ma'lumotlari kiritilmagan", 'error');
                    }
                    else {
                        alert("Sana ma'lumotlarni noto'g'ri")
                    }
                }
            })

            $.ajax({
                url: `${url}?action=teacherCheck`,
                data: {
                    title: '2',
                    todayDate: sanaFormat,
                    className: $('#teacherPageClassId').val(),
                    teacherId: $('#teacherIdPage').val(),
                    lessonId:$('#teacherPageLessonId').val()
                },
                type: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.status == 300) {
                        $('.teacher-madal').addClass('active');
                        $('.information-students').addClass('hide');
                        modal(response.message, 'error');
                    }
                    else if (response.status == 200) {
                        $('.teacher-madal').removeClass('active');
                        $('.information-students').removeClass('hide');
                        modal(response.message, 'success')
                    }
                }

            })
        }
        else if ($('#todayDateJs').val() == '') {
            modal("Sana ma'lumotlari kiritilmagan", 'error');
        }
        else {
            modal("Sana ma'lumotlarni noto'g'ri", 'error')
        }
    });


    $('#addTeachersStudentsData').on('click', (e) => {
        e.preventDefault();
        
        studentIdArray = [];
        studentGreatArray = [];

        function arrayPush(items, array) {
            items.each(function () {
                array.push($(this).val());
            });

        }

        arrayPush($('.studentGreatID'), studentIdArray)
        arrayPush($('.studentGreatClassIdGrate'), studentGreatArray)

        $.ajax({
            url: `${url}?action=addTeachersStudentsData`,
            data: {
                yearsId: $('#teacherPageYearsId').val(),
                teachersId: $('#teacherIdPage').val(),
                classId: $('#teacherPageClassId option:selected').attr('name'),
                todayDate: $('#todayDateJs').val(),
                studentIdString: studentIdArray.join(','),
                studentGreatString: studentGreatArray.join(','),
                lessonId:$('#teacherPageLessonId').val()

            },
            type: "GET",
            dataType: "json",
            success: function (response) {
                if (response.data == 'active') {
                    modal("O'quvchi ma'lumotlari qabul qilindi", 'success');
                    $('.teacher-madal').addClass('active');
                    $('.information-students').addClass('hide');
                }
                else {
                    modal("Xatolik mavjud", 'error')
                }

            }
        })

    });




})

