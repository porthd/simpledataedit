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



if (typeof PorthdSimpledataedit === 'undefined') {
    var PorthdSimpledataedit = {};
}

PorthdSimpledataedit = {
    ...PorthdSimpledataedit,
    focusin: {
    },
    focusout: {   
    }
}    
PorthdSimpledataedit.pathForSimpledataeditUpdate = "/simpledataedit";
/** Check working code */
console.log('all works fine. Current state of global variable `PorthdSimpledataedit`');
console.log(PorthdSimpledataedit);
