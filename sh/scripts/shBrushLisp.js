/**
 * SyntaxHighlighter 3.0 brush for Lisp.
 * 2012-05-09, Roald Fernandez
 * http://swarminglogic.com
 * Version 1.0
 *
 * Based on the work of Knut Haugen, which was written for an older
 * version of SyntaxHighlighter, and was integrated into wordpress.
 *
 * Various keywords have been added and will be continuously added
 * based on need.
 *
 * The previous header, verbatim, follows:
 *********************************************************************************
 *
 * SyntaxHighlighter 2.0 brush for Lisp.
 * 2009-10-14, Knut Haugen
 * http://blog.knuthaugen.no/
 *
 * Based on the 1.5 brush by Sanghyuk Suh at http://han9kin.doesntexist.com/
 *
 * This library is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Lesser General Public License as published by the
 * Free Software Foundation; either version 2.1 of the License, or (at your option)
 * any later version.
 *
 * This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *  See the GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along with
 * this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 */

;(function()
{
    // CommonJS
    typeof(require) != 'undefined' ? SyntaxHighlighter = require('shCore').SyntaxHighlighter : null;

    function Brush()
    {

        var funcs     = 'lambda list progn mapcar car cdr reverse member append format ' +
                        'set-frame-parameter setq global-set-key kbd';
        var keywords  = 'let while unless cond if eq t nil defvar dotimes setf listp numberp not equal ' +
                        'interactive optional';
        var macros    = 'loop when dolist dotimes defun';
        var operators = '> < + - = * / %';

        this.regexList = [
            { regex: SyntaxHighlighter.regexLib.doubleQuotedString, css: 'string' },
            { regex: new RegExp('&\\w+;', 'g'), css: 'plain' },
            { regex: new RegExp(';.*', 'g'), css: 'comments' },
            { regex: new RegExp("'(\\w|-)+", 'g'), css: 'variable' },
            { regex: new RegExp(this.getKeywords(keywords), 'gm'), css: 'keyword' },
            { regex: new RegExp(this.getKeywords(macros), 'gm'), css: 'color2 bold' },
            { regex: new RegExp(this.getKeywords(funcs), 'gm'),	css: 'functions' }
        ];
    };

    Brush.prototype	= new SyntaxHighlighter.Highlighter();
    Brush.aliases	= ['lisp', 'Lisp'];

    SyntaxHighlighter.brushes.Lisp = Brush;

    // CommonJS
    typeof(exports) != 'undefined' ? exports.Brush = Brush : null;
})();

