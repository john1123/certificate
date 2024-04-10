BX.ready(function () {
    let list  = document.getElementById('certificates-available');
    let input = document.getElementById('certificate-current');
    let links = list.getElementsByTagName('a');
    input.value = links[0].text;
    for(var i = 0; i < links.length; i++) {
        links[i].addEventListener('click', function() {
            input.value = this.text;
        }, false);
    }
})