document.getElementById('ykf-brx-fontawesome-pro-admin-upload-link').addEventListener('click', init);

function init() {
    let iframe_src = window.ykf_brx_fontawesome_pro_admin.iframe_src.replace(/"/g, '&quot;');

    const modal = document.createElement('div');
    modal.id = 'ykfbxfapro';
    modal.className = 'ykfbxfapro';

    modal.innerHTML = `
        <div class="ykfbxfapro-content">
            <span class="ykfbxfapro-close-btn">&times;</span>
            <iframe srcdoc="${iframe_src}" frameborder="0"></iframe>
        </div>
    `;
    modal.style.display = 'block';

    document.getElementById('wpcontent').appendChild(modal);

    document.getElementsByClassName('ykfbxfapro-close-btn')[0].addEventListener('click', () => {
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
