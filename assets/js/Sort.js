/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Sorting items in the sub menu.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class Sort {

    constructor() {
        /**
         * True if direction is ascending, false if direction is descanting.
         *
         * @type {boolean}
         */
        this.asc = true;
    }

    /**
     * Sorting items in the sub menu.
     *
     * @param itemId
     */
    items(itemId) {
        let item = document.getElementById(itemId);
        let subMenu = item.lastElementChild;

        if (subMenu.hasChildNodes()) {

            let children = subMenu.childNodes;
            let childrenArr = [];

            for (let j in children) {

                if (children[j].nodeType == 1) { // get rid of the whitespace text nodes
                    childrenArr.push(children[j]);
                }
            }

            if (this.asc) {
                childrenArr.sort(function(a, b) {
                    return a.id == b.id
                        ? 0
                        : (a.id < b.id ? 1 : -1);

                });
                this.asc = false;
            }
            else {
                childrenArr.reverse();
                this.asc = true;
            }

            for (let i = 0; i < childrenArr.length; ++i) {
                subMenu.appendChild(childrenArr[i]);
            }
        }
    }
}

let sort = new Sort();

export default sort;
