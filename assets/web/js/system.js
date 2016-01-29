/**
 * Languages Array
 * */
function Language(language) {
    this.get = function (category, message) {
        if (language[category][message] !== undefined) {
            return language[category][message];
        } else {
            return message;
        }
    }
}
var Lang = new Language(language);

///**
//*
//* */
//function StorageClass() {
//    this.set = function(key, string){
//        localStorage.setItem(key, string);
//    };
//    this.get = function(key){
//        localStorage.getItem(key);
//    };
//    this.clear = function(){
//        localStorage.clear();
//    }
//}
//var storage = new StorageClass();

/**
* Отсылка ajax запроса и вывод результата в уведомлениии
* */
function Request(){
    this.send = function(obj){
        var params = {
            type: 'GET',
            url: obj.data('url') ? obj.data('url') : obj.attr('href')
        };
        if(obj instanceof jQuery){
            params = $.extend(params, obj.data());
        } else {
            params = $.extend(params, obj);
        }
        $.ajax({
            type: params.type,
            url: params.url,
            success: function (data) {
                data = $.parseJSON(data);
                params.containerForUpdate != 'false' && $.pjax.reload({container: '#' + params.containerForUpdate.replace('container', 'pjax')});
                params.containerForDelete != 'false' && $('#' + params.containerForDelete).fadeOut();
                params.modalId != 'false' && $('#' + params.modalId).modal('hide');
                setTimeout(function () {
                    new PNotify({
                        title: Lang.get('system', 'Notify'),//todo Lang.get()
                        text: data.message,
                        type: data.type,
                        hide: false,
                        width: "280px",
                        buttons: {
                            sticker: false,
                            labels: {close: ""}
                        }
                    });
                }, 300);
            }
        });
    }
}

/**
 * @constructor
 */
function ModalsStorage(){
    this.storage = {};
    this.addInStorage = function(modalId, buttonId){
        var active;
        if(active = this.getActiveModalFromStorage()){
            this.storage[active.modalId]['active'] = false;
        }
        var modal = {
            modalId: modalId,
            parent: this.storage.active ? this.storage.active : false,
            active: true,
            buttonId: buttonId ? buttonId : false
        };
        this.storage[modalId] = modal;
        this.storage.active = modal;
    };
    this.removeFromStorage = function(modalId){
        var modal = this.storage[modalId];
        if(modal.parent){
            //console.log(modal.parent);
            this.storage[modal.parent.modalId]['active'] = true;
            this.storage.active = this.storage[modal.parent.modalId];
        }
        this.storage[modalId] = false;
    };
    this.getActiveModalFromStorage = function(){
        return this.storage.active;
    };
}

var modalsStorage = new ModalsStorage();

/**
 * Всплывающие модальные окна
 * */
function Modal() {
    this.params = {};
    this.loadParams = function (obj) {
        if (obj instanceof jQuery) {
            this.params = $.extend(this.params, obj.data())
        }
        return this.params;
    };
    this.display = function(modalId){
        $('#' + modalId)
            .on('hidden.bs.modal', function (e) {
                //modalsStorage.storage[modalId]['parent'] == false && $('html, body').css('overflow', 'auto');
                modalsStorage.removeFromStorage(modalId);//удалить окно и пометить родителя активным
                $(this).remove();
                //console.log('removed!');

            })
            .on('shown.bs.modal', function(e){
                $('.modal-body').css('maxHeight', $(window).height() - 120);
            })
            .modal();
        return false;
    };
    this.displayDialog = function (obj) {
        //$('html, body').css('overflow', 'hidden');
        var self = this;
        var modal = {};
        var modalId = 'id-' + $.now();
        var buttonId = obj.attr('id');
        modal.buttons = [
            Mustache.render($('#modal-box-button').html(), {
                class: 'btn btn-default',
                label: Lang.get('system', 'Close')//todo Lang.get()
            }),
            Mustache.render($('#modal-box-link').html(), {
                class: 'btn btn-danger jsRequest',
                label: Lang.get('system', 'Continue'),//todo Lang.get()
                link: obj.attr('href'),
                data: {
                    modalId: modalId,
                    containerForUpdate: obj.parents('.kv-grid-container').attr('id') ? obj.parents('.kv-grid-container').attr('id') : false,
                    containerForDelete: obj.data('modalContainerForDelete') ? obj.data('modalContainerForDelete') : false
                }
            })
        ];
        modal.options = $.extend({
            id: modalId,
            title: Lang.get('system', 'Confirmation'),
            footer: Mustache.render($('#modal-box-footer').html(), {buttons: modal.buttons.join('')})
        }, self.loadParams(obj));
        modal.body = Mustache.render($('#modal-box').html(), modal.options);
        $('body').append(modal.body);
        modalsStorage.addInStorage(modalId, buttonId);//Пометить окно активным
        self.display(modalId);
        return false;
    };

    /**
     * Модальное окно для показа ajax подгружаемого контента
     * @property obj - объект jquery, по которому был клик для вызова модального окна
     * */
    this.displayAjaxContent = function(obj){
        //$('html, body').css('overflow', 'hidden');
        var self = this;
        var modal = {};
        var modalId = 'id-' + $.now();
        var buttonId = obj.attr('id');
        $.ajax({
            url: obj.attr('href'),
            success: function(data){
                modal.options = $.extend({
                    id: modalId,
                    title: Lang.get('system', 'Detail view'),
                    message: data
                }, self.loadParams(obj));
                modal.body = Mustache.render($('#modal-box').html(), modal.options);
                $('body').append(modal.body);
                modalsStorage.addInStorage(modalId, buttonId);//Пометить окно активным
                self.display(modalId);
            }
        });
    };
}

$(function () {

    //Tooltips and Popovers hack
    $("[data-toggle='tooltip']").tooltip();
    $("[data-toggle='popover']").popover();

    //models fix for select2 focus
    $.fn.modal.Constructor.prototype.enforceFocus = function () {};

    /**
     * Показываем уведомления
     * */
    if (typeof notification !== 'undefined') {
        new PNotify({
            title: Lang.get('system', 'Notify'),//todo Lang.get()
            text: notification.text,
            type: notification.type,
            hide: false,
            width: "280px",
            buttons: {
                sticker: false,
                labels: {close: ""}
            }
        });
    }

    /**
    * Контролируем размер окна браузера
    * */
    $(window).resize(function(){
        var height = $(window).height();
        $('.modal-body').css('maxHeight', height - 120);
    });

    /**
     * Document Events
     * */
    $(document)
        //диалог в модальном окне с ajax запросом
        .on('click', '.jsDialog', function () {
            (new Modal()).displayDialog($(this));
            return false;
        })
        .on('click', '.jsRequest', function(){
            (new Request).send($(this));
            return false;
        })
        //ajax загрузка контента
        .on('click', '.jsOpen', function () {
            (new Modal()).displayAjaxContent($(this));
            return false;
        })
        //Ошибка во время запроса
        .on('ajaxError', function (XMLHttpRequest, response, errorThrown) {
            if (typeof(response.responseText) !== 'undefined') {
                new PNotify({
                    title: Lang.get('system', 'Error'),//todo Lang.get()
                    text: response.responseText,
                    type: 'danger',
                    hide: false,
                    width: "280px",
                    buttons: {
                        sticker: false,
                        labels: {close: ""}
                    }
                });
            }
        });


});

