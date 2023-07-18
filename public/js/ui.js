/**
 * Mobile Sidebar
 */
const sidebar = document.querySelector('.navbar-toggler.navbar-toggler-right.d-lg-none.align-self-center')

if(sidebar) {
  sidebar.addEventListener('click', () => {
    document.querySelector('.sidebar.sidebar-offcanvas').classList.toggle('active')
  })

}

/**
 * Flash message
 */
const notification = document.querySelector('.notification')

const handleNotification = (notification) => {
  if(notification) {
    document.addEventListener('DOMContentLoaded', () => {
      (document.querySelectorAll('.notification .close') || []).forEach((btnClose) => {
        const snotification = btnClose.parentNode;
    
        btnClose.addEventListener('click', () => {
          snotification.parentNode.removeChild(notification);
        });
      });
    });

    setTimeout(() => {
      notification.style.left = '10px';
    }, 100)
  
    setTimeout(() => {
      notification.style.left = '-600px';
    }, 5000)
  }
}


/**
 *  change password modal
 */
// const userIdInput =document.querySelector('#changePasswordModal input[name=id]')
// const oldPasswordInput = document.querySelector('#changePasswordModal input[name=oldPassword]')
// const newPasswordInput = document.querySelector('#changePasswordModal input[name=newPassword]')
// const newPassword2Input = document.querySelector('#changePasswordModal input[name=newPassword2]')
// const changePasswordSubmit = document.querySelector('#changePasswordModal #changePasswordSubmit')
// const changePasswordError = document.querySelector('#changePasswordModalErrorMsg')

// const handleChangePasswordModal = (userIdInput, oldPasswordInput, newPasswordInput, newPassword2Input, changePasswordSubmit, changePasswordError) => {

//   if(
//     userIdInput &&
//     oldPasswordInput &&
//     newPasswordInput &&
//     newPassword2Input &&
//     changePasswordSubmit &&
//     changePassword
//   ) {
//     changePasswordSubmit.addEventListener('click', () => {
//       if(!oldPasswordInput.value || !newPasswordInput.value || !newPassword2Input.value) {
//         changePasswordError.innerHTML = `
//           <ul class="my-3 py-3">
//             <li>Vui lòng nhập đầy đủ thông tin</li>
//           </ul>
//         `
//       }
    
//       else if(newPasswordInput.value.length < 6 || newPassword2Input.value.length < 6) {
//         changePasswordError.innerHTML = `
//         <ul class="my-3 py-3">
//           <li>Mật khẩu phải từ 6 ký tự trở lên</li>
//         </ul>
//       `
//       }
    
//       else if(newPasswordInput.value !== newPassword2Input.value) {
//         changePasswordError.innerHTML = `
//           <ul class="my-3 py-3">
//             <li>Mật khẩu nhập lại không chính xác</li>
//           </ul>
//         `
//       }
    
//       else {
//         changePassword(userIdInput.value, oldPasswordInput.value, newPasswordInput.value, newPassword2Input.value)
//       }
//     })

//   }
// }

// handleChangePasswordModal(userIdInput, oldPasswordInput, newPasswordInput, newPassword2Input, changePasswordSubmit, changePasswordError)


handleNotification(notification)


