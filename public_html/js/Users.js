class Users {

    // Fetch all users / staff
    display_users() {
        let formData = new FormData();
        formData.append('display_users', 'display_users')

        fetch('php/controller/c_user.php', {
            method: "POST",
            body: formData
        }).then((response)=>{
            console.log(response);
            return response.json();
        }).then((response_data)=>{
            console.log(response_data);
            let user_list = '';

            if (response_data.error) {
                new Notification().create_notification(response_data.error, "error");
            } else {
                response_data.map((user) => {
                    user_list += `
                       <tr>
                            <th scope="row" class="align-middle">${user.user_id}</th>
                            <td class="align-middle">${user.fullname}</td>
                            <td class="align-middle">${user.email}</td>
                            <td class="align-middle">
                            <select class="form-select" id="drop${user.user_id}" onchange="new Users().dropdownChange(event, ${user.user_id})" disabled>
                            
                    `;

                    if(user.user_type === 'staff') {
                        user_list += `
                                <option value="customer">Customer</option>
                                <option value="staff" selected>Staff</option>
                                `;
                            } else {
                                user_list += `
                                <option value="costumer" selected>Customer</option>
                                <option value="staff">Staff</option>
                                `;
                            }
                            
                            user_list += `
                            </select>
                            </td>
                            <td class="align-middle">
                                <button type="button" class="btn btn-warning edit-btn" id="${user.user_id}" onClick="new Users().editBtn(this.id)">Edit</button>
                                <button type="button" class="btn btn-danger delete-btn" id="${user.user_id}" onClick="new Users().deleteBtn(this.id)">Delete</button>
                            </td>
                        </tr> `;
                    
                })
                document.querySelector('#table-body').innerHTML = user_list;
            }
        })

    }

    editBtn(id) {
        console.log('edit clicked')
        const dropdown = document.querySelector(`#drop${id}`);

        const change = confirm("Are you sure you want to change the position of this user?")

        if(change) 
            dropdown.disabled = false;

    }

    deleteBtn(id) {
        console.log('delete clicked')
        if(confirm("Are you sure you want to delete this user ?")) {
            let formData = new FormData();
            formData.append('delete_user', 'delete_user');
            formData.append('user_id', id);

            fetch('php/controller/c_user.php', {
                method: "POST",
                body: formData
            }).then((res) => {
                return res.json();
            }).then((res_data) => {
                new Users().display_users();
            })

        }
    }

    dropdownChange(event, id) {
        let dropDown = event.target;
        let newType = dropDown.value;

        let formData = new FormData();
        formData.append('update_user', 'update_user');
        formData.append('user_id', id);
        formData.append('new_type', newType)

        fetch('php/controller/c_user.php', {
            method: "POST",
            body: formData
        }).then((res) => {
            return res.json();
        }).then((res_data) => {
            console.log(res_data);
            dropDown.disabled = true;
            new Users().display_users();        
        })

    }

    dropdownClick(e) {
        const caller = e.target || e.srcElement;
        console.log(caller);
    }


}