<script>

    function ShowElement(el) {
        el.classList.add('show-el');
        el.classList.remove('hide-el');
    }

    function HideElement(el) {
        el.classList.add('hide-el');
        el.classList.remove('show-el');
    }

    function ShowLoader() {
        let loader = document.createElement("div");
        loader.className = 'loader';
        loader.innerHTML = '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div><div class="text-in-spinner"></div>';
        document.body.prepend(loader);
    }

    function HideLoader() {
        document.body.querySelector('.loader').remove();
    }

    function ShowModal(content) {
        const modal = document.body.querySelector('.modal');
        modal.classList.add('show-el');
        modal.classList.remove('hide-el');
        modal.querySelector('.modal-content').innerHTML = content;
    }

    function HideModal() {
        const modal = document.body.querySelector('.modal');
        modal.classList.remove('show-el');
        modal.classList.add('hide-el');
    }

    function ShowModalFlash(content, closeit) {
        const modalFlash = document.body.querySelector('.modal-flash-message');
        modalFlash.classList.add('show-el');
        modalFlash.classList.remove('hide-el');
        modalFlash.querySelector('.modal-flash-message-content').innerHTML = content;
        if (closeit) {
            setTimeout(() => {
                HideModalFlash();
            }, 1500)
        }
    }

    function HideModalFlash() {
        const modalFlash = document.body.querySelector('.modal-flash-message');
        modalFlash.classList.remove('show-el');
        modalFlash.classList.add('hide-el');
    }

    function getDataFormContainer(container, validate) {
        if (validInputEmpty(container) || !!!validate) {
            let data = [];
            document.body.querySelectorAll('.' + container + ' input, .' + container + ' select, .' + container + ' textarea').forEach((el) => {
                if (el.type === 'file') {
                    for (let i = 0; i < el.files.length; i++) {
                        data[el.id + '-' + i] = el.files[i];
                    }
                } else if (el.type === 'checkbox') {
                    data[el.id] = el.checked;
                } else {
                    data[el.id] = el.value;
                }
            });
            return data;
        } else {
            return false;
        }
    }

    function validInputEmpty(container) {
        let validate = true;
        document.body.querySelectorAll('.' + container + ' .need-validate').forEach((el) => {
            let strValue = el.value;
            if (strValue === '' || strValue === null || strValue === undefined) {
                validate = false;
                el.classList.add('highlight');
                el.addEventListener('input', () => {
                    el.classList.remove('highlight')
                });
                el.addEventListener('change', () => {
                    el.classList.remove('highlight')
                });
            } else {
                el.classList.remove('highlight')
            }
        });
        return validate;
    }

    function ShowFlashMessage(msg, time) {
        time = time === undefined ? 1500 : time
        let containerFlashMessage = document.body.querySelector('.flash-message');
        containerFlashMessage.innerHTML = msg;
        containerFlashMessage.classList.add('show-el');
        setTimeout(() => {
            containerFlashMessage.classList.remove('show-el');
        }, time);
    }

    function Ajax(url, method, formDataRAW) {
        return new Promise(function(resolve, reject) {
            let formData = new FormData();
            if ( typeof(method) === "undefined" || method === null ) {
                method = 'get';
            }

            if ( typeof(formDataRAW) === "undefined" || formDataRAW === null ) {
                formDataRAW = {};
            } else {
                Object.keys(formDataRAW).forEach((key) => {
                    formData.append(key, formDataRAW[key]);
                })
            }

            formData.append('_token', '{{csrf_token()}}');

            let xhr = new XMLHttpRequest();
            xhr.open(method, url, true);

            xhr.onload = function() {
                if (this.status == 200) {
                    try {
                        resolve(JSON.parse(this.response));
                    } catch (e) {
                        resolve(this.response);
                    }

                } else {
                    let error = new Error(this.statusText);
                    error.code = this.status;
                    reject(error);
                }
            };

            xhr.upload.onprogress = function(event) {
                let percent = parseInt(event.loaded * 100 / event.total);
                let textInLoader = document.body.querySelector('.text-in-spinner');
                if (textInLoader !== null) {
                    textInLoader.innerHTML = percent + '%';
                }

                console.log( 'Загружено на сервер ' + event.loaded + ' байт из ' + event.total );
            }

            xhr.onerror = function() {
                reject(new Error("Network Error"));
            };

            xhr.send(formData);
        });
    }
</script>
