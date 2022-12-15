class Users {

    // Fetch all users / staff
    display_staff() {
        let formData = new FormData();
        formData.append('display_staff', 'display_staff')

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
                            <th class="align-middle">${user.fullname}</th>
                            <th class="align-middle">${user.email}</th>
                            <th class="align-middle">
                            <select class="form-select" id="drop${user.user_id}" onchange="new Users().dropdownChange(event)" disabled>
                            
                    `;

                    if(user.user_type === 'staff') {
                        user_list += `
                                <option value="costumer">Costumer</option>
                                <option value="staff" selected>Staff</option>
                                `;
                            } else {
                                user_list += `
                                <option value="costumer" selected>Costumer</option>
                                <option value="staff">Staff</option>
                                `;
                            }
                            
                            user_list += `
                            </select>
                            </th>
                            <th class="align-middle">
                                <button type="button" class="btn btn-warning edit-btn" id="${user.user_id}" onClick="new Users().editBtn(this.id)">Edit</button>
                                <button type="button" class="btn btn-danger delete-btn" id="${user.user_id}" onClick="new Users().deleteBtn(this.id)">Delete</button>
                            </th>
                        </tr> `;
                    
                })
                document.querySelector('#table-body').innerHTML += user_list;
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
    }

    dropdownChange(event) {
        let dropDown = event.target;

        dropDown.disabled = true;        
    }

    dropdownClick(e) {
        const caller = e.target || e.srcElement;
        console.log(caller);
    }


}