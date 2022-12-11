class Dashboard {
    dashboard() {
        new Dashboard().get_information();
    }
    get_information() {
        let fotm_data = new FormData();
        fotm_data.append('get_information', 'get_information');
        fetch('php/controller/c_dashboard.php', {
            method: "POST",
            body: fotm_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data.data);
            if (response_data.error) {
                new Notification().create_notification(response_data.error, "error");
            } else {
                document.getElementById('total-orders').innerHTML = response_data.data[0].total_orders;
                document.getElementById('total-pending').innerHTML = response_data.data[0].total_pending;
                document.getElementById('total-staffs').innerHTML = response_data.data[0].total_staffs;
                document.getElementById('total-users').innerHTML = response_data.data[0].total_users;
                document.getElementById('total-cancelled').innerHTML = response_data.data[0].total_cancelled;
                document.getElementById('total-items').innerHTML = response_data.data[0].total_items;
                document.getElementById('total-available').innerHTML = response_data.data[0].total_available;
            }
        });
    }

}