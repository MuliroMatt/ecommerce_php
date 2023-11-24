const inputFile = 
    document.querySelector('.picture-input');
    const pictureImage =
    document.querySelector('.picture-image');
    const pictureImageTxt = 'Escolha uma imagem';
    pictureImage.innerHTML = pictureImageTxt;

    inputFile.addEventListener("change", function(e) {
        const inputTarget = e.target;
        const file = inputTarget.files[0];

        if (file) {
            const reader = new FileReader();

            reader.addEventListener("load", function(e){
                const readerTarget = e.target;

                const img = document.createElement('img');
                img.src = readerTarget.result;
                img.classList.add('picture-img');
                
                pictureImage.innerHTML = '';
                pictureImage.appendChild(img);
            });

            reader.readAsDataURL(file);
        } else {
            pictureImage.innerHTML = pictureImageTxt;
        }
    });

    function MostraSenha() {
        var passwordInput = document.getElementById("senha");
        var passwordIcon = document.getElementById("MostraSenha");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordIcon.innerHTML = "<i class='bx bx-lock-open-alt'></i>";
        } else {
            passwordInput.type = "password";
            passwordIcon.innerHTML = "<i class='bx bxs-lock-alt'></i>";
        }
    }

    function change(element) {
        element.classList.toggle("zoom");
    }

    const myInput = document.getElementById("quantidade");
    function stepper(btn){
        let id = btn.getAttribute("id");
        let min = myInput.getAttribute("min");
        let max = myInput.getAttribute("max");
        let step = myInput.getAttribute("step");
        let val = myInput.getAttribute("value");
        let calcStep = (id == "increment") ? (step*1) : (step * -1);
        let newValue = parseInt(val) + calcStep;

        if(newValue >= min && newValue <= max){
            myInput.setAttribute("value", newValue);
        }
    }