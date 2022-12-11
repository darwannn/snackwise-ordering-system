class Closed_Date {
    display_closed_date() {
        document.getElementById('date').flatpickr({
            minDate: "today",
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
            defaultDate: `${new Date().getFullYear()}-${new Date().getMonth() + 1}-${new Date().getDate()}`
        });

        let form_data = new FormData();
        form_data.append('display_closed_date', 'display_closed_date');

        fetch('php/controller/c_closed_date.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();

        }).then(function (response_data) {
            let closed_date_list = "";
            console.log(response_data);
            if (response_data.error) {
                new Notification().create_notification(response_data.error, "error");
            } else {
                response_data.data.map(function (closed_date) {
                    closed_date_list += `
                    <div class="date-row">
                        <div class="date-container">
                            <span class="date">${closed_date.date}</span>
                        </div>
                        <div class="del-btn">
                            <button type="button" class="btn btn-danger" onclick="new Closed_Date().delete_closed_date(${closed_date.closed_date_id})"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                    `;/*`
                    <tr>
                    <td >${closed_date.date}</td>
                    <td ><button type="button" class="" onclick="new Closed_Date().delete_closed_date(${closed_date.closed_date_id})"><i class="fa-solid fa-trash"></i></button></td>
                    </tr>
                    `;*/

                });
            }
            document.getElementById("closed_date_list").innerHTML = closed_date_list;
        });
    }

    add_closed_date() {
        let form_data = new FormData(document.getElementById('closed_date_form'));
        form_data.append('add_closed_date', 'add_closed_date');
        fetch('php/controller/c_closed_date.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            if (response_data.success) {
                new Notification().create_notification(response_data.success, "success");
            } else if (response_data.error) {
                new Notification().create_notification(response_data.error, "error");
            }
            new Closed_Date().display_closed_date();
        });
    }

     delete_closed_date(closed_date_id) {
        if (confirm("Are you sure you want to remove it?")) {
            let form_data = new FormData(document.getElementById('closed_date_form'));
            form_data.append('delete_closed_date', 'delete_closed_date');
            form_data.append('closed_date_id', closed_date_id);
            fetch('php/controller/c_closed_date.php', {
                method: "POST",
                body: form_data
            }).then(function (response) {
                return response.json();

            }).then(function (response_data) {
                new Closed_Date().display_closed_date();
                if (response_data.success) {
                    new Notification().create_notification(response_data.success, "success");
                } else if (response_data.error) {
                    new Notification().create_notification(response_data.error, "error");
                }
            });
        }
    }


}