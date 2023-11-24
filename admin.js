document.getElementById('yos-brx-fontawesome-pro-admin-upload-link').addEventListener('click', init);

function init() {
    let iframe_src = window.yos_brx_fontawesome_pro_admin.iframe_src.replace(/"/g, '&quot;');

    const modal = document.createElement('div');
    modal.id = 'yosbrxfapro';
    modal.className = 'yosbrxfapro';

    modal.innerHTML = `
        <div class="yosbrxfapro-content">
            <span class="yosbrxfapro-close-btn">&times;</span>
            <iframe srcdoc="${iframe_src}" frameborder="0"></iframe>
        </div>
    `;
    modal.style.display = 'block';

    document.getElementById('wpcontent').appendChild(modal);

    document.getElementsByClassName('yosbrxfapro-close-btn')[0].addEventListener('click', () => {
        document.getElementById('wpcontent').removeChild(modal);
    });

    function click_outside(e) {
        if (e.target == modal) {
            document.getElementById('wpcontent').removeChild(modal);
            window.removeEventListener('click', click_outside);
        }
    }

    // if user clicks outside of modal, close it
    window.addEventListener('click', click_outside);
}
