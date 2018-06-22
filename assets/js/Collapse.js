/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Collapse.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class Collapse {

    constructor() {
        /**
         * True if any sub menu is collapsed.
         *
         * @type {boolean}
         */
        this.isCollapsed = false;
    }

    /**
     * Collapse one sub menu.
     *
     * @param itemId
     */
    oneSubMenu(itemId) {
        let item = document.getElementById(itemId);
        let subMenu = item.lastElementChild;

        if (subMenu.style.display == 'none') {
            subMenu.style.display = '';
            this.isCollapsed = false;
        }
        else {
            subMenu.style.display = 'none';
            this.isCollapsed = true;
        }
    }

    /**
     * Collapse all sub menus.
     */
    allSubMenus() {
        let subMenus = document.getElementsByClassName('sub-menu');

        if (this.isCollapsed) {
            [].forEach.call(subMenus, function(subMenu) {
                subMenu.style.display = ''
            });

            this.isCollapsed = false;
        }
        else {
            [].forEach.call(subMenus, function(subMenu) {
                subMenu.style.display = 'none'
            });

            this.isCollapsed = true;
        }
    }
}

let collapse = new Collapse();

export default collapse;
