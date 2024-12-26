document.addEventListener('DOMContentLoaded', function() {
    const deployButton = document.getElementById('trigger-deploy');
    
    if (!deployButton) return;

    deployButton.addEventListener('click', async function() {
        // Disable button and show loader
        deployButton.classList.add('loading');
        deployButton.disabled = true;

        try {
            const formData = new FormData();
            formData.append('action', 'trigger_deployment');
            formData.append('nonce', deployManagerData.nonce);

            const response = await fetch(deployManagerData.ajaxurl, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                showNotification('success', 'Deployment triggered successfully!');
                // Reload page to update logs after a brief delay
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification('error', `Error: ${data.data}`);
            }
        } catch (error) {
            showNotification('error', 'Error connecting to the server');
        } finally {
            // Re-enable button and hide loader
            deployButton.classList.remove('loading');
            deployButton.disabled = false;
        }
    });
});

function showNotification(type, message) {
    // Remove any existing notification
    const existingNotification = document.querySelector('.deploy-notification');
    if (existingNotification) {
        existingNotification.remove();
    }

    // Create new notification
    const notification = document.createElement('div');
    notification.className = `deploy-notification ${type}`;
    notification.textContent = message;

    // Add to DOM
    document.querySelector('.deploy-section').appendChild(notification);

    // Remove after 3 seconds
    setTimeout(() => {
        notification.classList.add('fade-out');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

document.addEventListener('DOMContentLoaded', function() {
    const deployButton = document.getElementById('trigger-deploy');
    
    if (!deployButton) return;

    deployButton.addEventListener('click', async function() {
        // Disable button and show loader
        deployButton.classList.add('loading');
        deployButton.disabled = true;

        try {
            const formData = new FormData();
            formData.append('action', 'trigger_deployment');
            formData.append('nonce', deployManagerData.nonce);

            const response = await fetch(deployManagerData.ajaxurl, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                showNotification('success', 'Deployment triggered successfully!');
                // Reload page to update logs after a brief delay
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification('error', `Error: ${data.data}`);
            }
        } catch (error) {
            showNotification('error', 'Error connecting to the server');
        } finally {
            // Re-enable button and hide loader
            deployButton.classList.remove('loading');
            deployButton.disabled = false;
        }
    });
});

function showNotification(type, message) {
    // Remove any existing notification
    const existingNotification = document.querySelector('.deploy-notification');
    if (existingNotification) {
        existingNotification.remove();
    }

    // Create new notification
    const notification = document.createElement('div');
    notification.className = `deploy-notification ${type}`;
    notification.textContent = message;

    // Add to DOM
    document.querySelector('.deploy-section').appendChild(notification);

    // Remove after 3 seconds
    setTimeout(() => {
        notification.classList.add('fade-out');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}