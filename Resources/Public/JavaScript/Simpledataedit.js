"use strict"

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Dr. Dieter Porthd <info@mobger.de>
 *
 *  All rights reserved
 *
 *  This script iSimpledataedits free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

class Simpledataedit extends HTMLDivElement {
    constructor() {
        super();
        this.attachShadow({ mode: 'open' });
    }
}

class Simpledatapopup extends HTMLDivElement {
    constructor() {
        super();
        this.attachShadow({ mode: 'open' });
    }
}

if (typeof PorthdSimpledataedit === 'undefined') {
    var PorthdSimpledataedit = {};
}

PorthdSimpledataedit = {
    ...PorthdSimpledataedit, // expand object
    contentEditable: document.querySelectorAll('simpledataedit[contenteditable]'),
    setInitialErrorMessage: function() {
        console.log('Initial error for data-conversion');
        console.log(node);
        alert('the javaScript-Conversioln of the Editorclass `'+node.dataset.editor+
            '` went wrong. The Javascript function generated not '+
            'the current innerHTML-code form the content-informations. More infos see in Console.log');
    },
    ajaxCall: function (node) {

    },
    initRender: function() {
        contentEditable.forEach((node) => {
            node.addEventListener('focusin', () => {
                const editor = node.dataset.editor;
                node.dataset.focusstorage = null;
                if (typeof PorthdSimpledataedit.focusin[editor] === 'function') {
                    const transform = PorthdSimpledataedit.focusin[editor];
                    if (node.innerHTML !== (transform(node))) {
                        this.setInitialErrorMessage(node);
                    }
                }
            });
        })

    },
    initFocusin: function() {
        contentEditable.forEach((node) => {
            node.addEventListener('focusin', () => {
                const editor = node.dataset.editor;
                node.dataset.focusstorage = node.innerHTML;
                if (typeof PorthdSimpledataedit.focusin[editor] === 'function') {
                    const transform = PorthdSimpledataedit.focusin[editor];
                    node.innerHTML = transform(node);
                }
            });
        })
    },
    initFocusout: function() {
        contentEditable.forEach((node) => {
            node.addEventListener('focusout', () => {
                const editor = node.dataset.editor;
                if (typeof PorthdSimpledataedit.focusout[editor] === 'function') {
                    const transform = PorthdSimpledataedit.focusout[editor];
                    node.dataset.content = transform(node.innerHTML);
                }
                const flag = (node.dataset.focusstorage !== node.innerHTML);
                node.dataset.focusstorage = null;
                if (flag) {
                    this.ajaxCall(node);
                }
            });
        })
    },
}



