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

handleNotification(notification)


/**
 * Loading
*/

function displayLoading(loader) {
  document.querySelector(loader).innerHTML = 
  `
    <div class="loading">
      <div class="loading__content"></div>
    </div>
  `

  setTimeout(() => {
    if(document.querySelector(loader + ' .loading')) document.querySelector(loader + ' .loading').style.display = 'none'
  }, 5000)
}

function hideLoading(loader) {
  if(document.querySelector(loader + ' .loading')) document.querySelector(loader + ' .loading').style.display = 'none'

}
