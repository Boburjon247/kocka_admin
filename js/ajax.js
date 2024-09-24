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

    // yangi oquv yili qoshihs
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
                                <button class="editGuruhName"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button ><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>    
                    `)
                });
            }
        });
    }

    fetchDataClass();


    // guruh yaratishda oquv yilini oqib olish uchun 

    function fetchDataAddYearsClass() {
        $.ajax({
            url: `${url}?action=fetchDataClassReadyYearsName`,
            type: "GET",
            dataType: "json",
            success: function (response) {
                let data = response.data;
                $('#addClassReady').empty();
                $.each(data, function (index, value) {                    
                    $('#addClassReady').append(`
                        <option value="${value.name}">${value.name}</option>
                    `)
                });
            }
        });
    }

    $('.addClassModalActiveJq').on('click', ()=>{
        fetchDataAddYearsClass();
    });

    










});