'use strict';

import { default as Component } from '/media/js/modules/components/component.js';

export class ArticleData {
    constructor(data){
        if (typeof data !== 'object') {
            throw new Error('Param continue reading data is invalid');
        }

        this.id = this._checkParm(data['article_id']);
        this.name = this._checkParm(data['article_name']);
        this.shortDescription = this._checkParm(data['article_short_description']);
        this.createdAt = this._checkParm(data['article_created_at']);
        this.imageId = this._checkParm(data['image_id']);
        this.imageDescription = this._checkParm(data['image_description']);
    }

    _checkParm(param) {
        if(typeof param !== 'string' || param === '') {
            throw new Error('Param article field data is invalid');
        }
        return param;
    }
}

export class Article extends Component {
    render(article) {
        if (! article instanceof ArticleData) {
            throw new Error('Param render article data is invalid');
        }
        var articleFullurl = encodeURI(this.getUrl(article.id));
        var comments = this.getComments() + '(' + Math.floor(Math.random() * 10) + ')';
    
        var mainContainer = this._createElement(
            'div', { 'class': 'col-12' }
        );

        var mainRow = this._createElement(
            'div', { 'class': 'row' }
        );
        
        var imgContainer = this._createElement(
            'div', { 'class': 'col-md-4' }
        );
        var imgLink = this._createElement(
            'a', { 'class': 'link-none', 'href': articleFullurl }
        );
        var img = this._createElement(
            'img', { 
                'class': 'img-fluid', 
                'src': `/img.php?id=${article.imageId}&type=webp&width=576&height=384`,
                'alt': article.imageDescription,
                'fetchpriority': 'low'
            }
        );
        imgLink.appendChild(img);
        imgContainer.appendChild(imgLink);

        var bodyContainer = this._createElement('div', { 'class': 'col-md-8' });
        var bodyTitle = this._createElement('h5', { 'class': 'card-title' });
        var bodyTitleLink = this._createElement(
            'a', { 'class': 'link-none', 'href': articleFullurl }, article.name
        );
        bodyTitle.appendChild(bodyTitleLink);
        var bodyParagraph = this._createElement('p', { 'class': 'card-text' });
        var bodyParagraphLink = this._createElement(
            'a', { 'class': 'link-none', 'href': articleFullurl }, article.shortDescription
        );
        bodyParagraph.appendChild(bodyParagraphLink);
        var bodyRead = this._createElement('div');
        var bodyReadLink = this._createElement(
            'a', { 'href': articleFullurl }, this.getRead()
        );
        bodyRead.appendChild(bodyReadLink);
        bodyContainer.appendChild(bodyTitle);
        bodyContainer.appendChild(bodyParagraph);
        bodyContainer.appendChild(bodyRead);

        var footerContainer = this._createElement('div', { 'class': 'col-12 text-secondary' });
        var footerRow = this._createElement('div', { 'class': 'row' });
        var footerComments = this._createElement('div', { 'class': 'col-12 font-monospace comments'}, comments);
        var footerData = this._createElement('div', { 'class': 'col-12 font-monospace comments'}, article.createdAt);
        footerRow.appendChild(footerComments);
        footerRow.appendChild(footerData);

        footerContainer.appendChild(footerRow);

        mainContainer.appendChild(mainRow);
        mainRow.appendChild(imgContainer);
        mainRow.appendChild(bodyContainer);
        mainRow.appendChild(footerContainer);

        this.node.appendChild(mainContainer);
    }

    getComments() {
        var comments = this._checkParm(this.node.dataset.comments);
        return comments;
    }
    
    getRead() {
        var read = this._checkParm(this.node.dataset.read);
        return read;
    }

    getUrl(id) {
        var url = this._checkParm(this.node.dataset.url);
        return url + '/' + id;
    }

    _checkParm(param) {        
        if(typeof param !== 'string' || param === '') {
            throw new Error('Param article check data is invalid');
        }
        return param;
    }
};

// export default Article;
