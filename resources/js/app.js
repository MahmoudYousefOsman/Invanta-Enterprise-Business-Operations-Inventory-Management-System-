import $ from 'jquery';
import './bootstrap';
import '@tabler/core';
import Modal from 'bootstrap/js/dist/modal';
import TomSelect from "tom-select";
import { Notyf } from 'notyf';
// import Alpine from 'alpinejs';

window.notyf = new Notyf();
window.bsmodal = Modal;
window.TomSelect = TomSelect;
// window.Alpine = Alpine;
// Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
    const el = document.getElementById("city");

    // ✅ Initialize only if the element exists
    if (el) {
        new TomSelect(el, {
            copyClassesToDropdown: false,
            dropdownParent: "body",
            controlInput: "<input>",
            render: {
                item: function (data, escape) {
                    if (data.customProperties) {
                        return `<div><span class="dropdown-item-indicator">${data.customProperties}</span>${escape(data.text)}</div>`;
                    }
                    return `<div>${escape(data.text)}</div>`;
                },
                option: function (data, escape) {
                    if (data.customProperties) {
                        return `<div><span class="dropdown-item-indicator">${data.customProperties}</span>${escape(data.text)}</div>`;
                    }
                    return `<div>${escape(data.text)}</div>`;
                },
            },
        });
    }
});

(function ($) {
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (json) {
                if (json.message) notyf.success(json.message);
            },
            error: function (jqXHR) {
                const json = jqXHR.responseJSON;
                if (json?.errors) {
                    Object.values(json.errors).flat().forEach(err => notyf.error(err));
                } else if (json?.message) {
                    notyf.error(json.message);
                } else {
                    notyf.error('حدث خطأ غير متوقع');
                }
            }
        });
    });

    if ($('.tinymce-textarea').length) {
        window.initTinymce?.();
    }
})(jQuery);
