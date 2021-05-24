"use strict"

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Dr. Dieter Porth <info@mobger.de>
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


class Sdecontainer extends HTMLDivElement {
    constructor() {
        super();
        this.attachShadow({mode: 'open'});
    }
}
class Simpledataedit extends HTMLDivElement {
    constructor() {
        super();
        this.attachShadow({mode: 'open'});
    }
}

// https://xd.adobe.com/view/cff448e6-d713-4d89-80a3-9a6b9dba91fc-9aa7/
class Simpledatapopup extends HTMLDivElement {
    constructor() {
        super();
        this.attachShadow({mode: 'open'});
    }
}
class Yamlor extends HTMLDivElement {
    constructor() {
        super();
        this.attachShadow({mode: 'open'});
    }
}

// https://xd.adobe.com/view/cff448e6-d713-4d89-80a3-9a6b9dba91fc-9aa7/
class Yamlorpopup extends HTMLDivElement {
    constructor() {
        super();
        this.attachShadow({mode: 'open'});
    }
}

if (typeof PorthdSimpledataedit === 'undefined') {
    var PorthdSimpledataedit = {};
}

PorthdSimpledataedit = {
    ...PorthdSimpledataedit, // expand object
    contentEditable: document.querySelectorAll('simpledataedit[contenteditable]'),
    popups: document.querySelectorAll('.simpledatapopup, .yamlorpopup'),
    setInitialErrorMessage: function () {
        console.log('Initial error for data-conversion');
        console.log(node);
        alert('the javaScript-Conversioln of the Editorclass `' + node.dataset.editor +
            '` went wrong. The Javascript function generated not ' +
            'the current innerHTML-code form the content-informations. More infos see in Console.log');
    },
    ajaxCall: function (node) {
        const myPath = PorthdSimpledataedit.pathForSimpledataeditUpdate;
        const myDatas = {};
        PorthdSimpledataedit.fullPropertyList.forEach((value) => {
            if (node.dataset.hasOwnProperty(value)){
                myDatas[value] = node.dataset[value];
            }
        });
        myDatas['raw'] = node.innerHTML;
        fetch(myPath, {
            method: "POST",
            body: JSON.stringify(myDatas),
            headers: {"content-type": "application/json"},
        })
            .then(response => response.json())
            .then(result => {
                if (result.status==='ok') {
                    node.dataset.hash = result.hash;
                    return;
                }
            })
            .catch(error => {
                const warnPop = node.parentNode.querySelector('.simpledatapopup');
                warnPop.classList.add('active');
                const errMsg = 'Request failed. ' + "\n" + node.dataset.table +
                    '[' + node.dataset.uid + ' - ' + node.dataset.fieldname + '] by ' + node.dataset.editor + "\n" +
                    ' Returned status of ' + error.status;
                warnPop.innerHTML = errMsg;
            });
    },
    initRender: function () {
        let list = this.contentEditable;
        list.forEach((node) => {
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
    initPopups: function () {
        let list = this.popups;
        list.forEach((node) => {
            node.addEventListener('click', () => {
                node.classList.remove('active')
            })
        })
    },
    initFocusin: function () {
        let list = this.contentEditable;
        list.forEach((node) => {
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
    initFocusout: function () {
        let list = this.contentEditable;
        list.forEach((node) => {
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
    initialze: function() {
        this.initRender();
        this.initFocusin();
        this.initFocusout();
        this.initPopups();
    }
}

PorthdSimpledataedit.initialze();

