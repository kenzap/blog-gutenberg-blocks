
const { __ } = wp.i18n; // Import __() from wp.i18n
const { Component } = wp.element;
const { MediaUpload, RichText, InspectorControls, PanelColorSettings } = wp.editor;
const { RangeControl, CheckboxControl, ToggleControl, RadioControl, PanelBody, ServerSideRender, SelectControl, TextControl, TextareaControl } = wp.components;
import { InspectorContainer, ContainerEdit } from '../commonComponents/container/container';

/**
 * Keys for new blocks
 * @type {number}
 */
let key = 0;

/**
 * The edit function describes the structure of your block in the context of the editor.
 * This represents what the editor will render when the block is used.
 *
 * The "edit" property must be a valid function.
 * @param {Object} props - attributes
 * @returns {Node} rendered component
 */
export default class Edit extends Component {
    state = {
        activeSubBlock: -1,
    };

    render() {
        const {
            className,
            attributes,
            setAttributes,
        } = this.props;

        return (
            <div className={ className }>
                <InspectorControls
                    setAttributes={ setAttributes }
                    { ...attributes }
                >
                    <PanelBody
                        title={ __( 'General', 'kenzap-blog' ) }
                        initialOpen={ false }
                    >

                        <TextControl
                            label={ __( 'Category', 'kenzap-blog' ) }
                            value={ attributes.category }
                            onChange={ ( category ) => setAttributes( { category } ) }
                            help={ __( 'Restrict posts by category. To view categories go to Posts > Categories section.', 'kenzap-blog' ) }
                        />

                        <RadioControl
                            label={ __( 'Image style', 'kenzap-blog' ) }
                            selected={ attributes.displayType }
                            options={ [
                                { label: __( 'Horizontal', 'kenzap-blog' ), value: 'kp-horizontal' },
                                { label: __( 'Square', 'kenzap-blog' ), value: 'kp-square' },
                                { label: __( 'Vertical', 'kenzap-blog' ), value: 'kp-vertical' },
                            ] }
                            onChange={ ( displayType ) => {
                                setAttributes( { displayType } );
                            } }
                        />

                        <RadioControl
                            label={ __( 'Image size', 'kenzap-blog' ) }
                            selected={ attributes.columns }
                            options={ [
                                { label: __( 'Normal', 'kenzap-blog' ), value: '' },
                                { label: __( 'Large', 'kenzap-blog' ), value: 'large' },
                            ] }
                            onChange={ ( columns ) => {
                                setAttributes( { columns } );
                            } }
                            help={ __( 'Works with wide layouts in desktop mode.', 'kenzap-blog' ) }
                        />

                        <ToggleControl
                            label={ __( 'Hide posts with no image', 'kenzap-blog' ) }
                            checked={ attributes.ignoreNoImage}
                            onChange={ (ignoreNoImage) => setAttributes( { ignoreNoImage } ) }
                        />

                        <ToggleControl
                            label={ __( 'Hide sticky posts', 'kenzap-blog' ) }
                            checked={ attributes.ignoreSticky}
                            onChange={ (ignoreSticky) => setAttributes( { ignoreSticky } ) }
                        />
                        
                        <ToggleControl
                            label={ __( 'Show category', 'kenzap-blog' ) }
                            checked={ attributes.showCategory}
                            onChange={ (showCategory) => setAttributes( { showCategory } ) }
                        />

                        <ToggleControl
                            label={ __( 'Show date', 'kenzap-blog' ) }
                            checked={ attributes.showDate}
                            onChange={ (showDate) => setAttributes( { showDate } ) }
                        />

                        <SelectControl
                            label={ __( 'Order by', 'kenzap-blog' ) }
                            value={ attributes.orderby }
                            options={ [
                                { label: __( 'Newest to Oldest', 'kenzap-blog' ), value: 'date/desc' },
                                { label: __( 'Oldest to Newest', 'kenzap-blog' ), value: 'date/asc' },
                                { label: __( 'A → Z', 'kenzap-blog' ), value: 'title/asc' },
                                { label: __( 'Z → A', 'kenzap-blog' ), value: 'title/desc' },
                            ] }
                            onChange={ ( orderby ) => {
                                setAttributes( { orderby } );
                            } }
                        />

                        <RangeControl
                            label={ __( 'Records per page', 'kenzap-blog' ) }
                            value={ attributes.per_page }
                            onChange={ ( value ) => setAttributes( { per_page: value } ) }
                            min={ 1 }
                            max={ 50 }
                            help={ __( 'Specify the maximum number of posts to display per page.', 'kenzap-blog' ) }
                        />
                     
                        <CheckboxControl
                            label={ __( 'Pagination', 'kenzap-blog' ) }
                            checked={ attributes.pagination}
                            onChange={ (pagination) => setAttributes( { pagination } ) }
                        />

                        <PanelColorSettings
                            title={ __( 'Text color', 'kenzap-blog' ) }
                            initialOpen={ false }
                            colorSettings={ [
                                    {
                                        value: attributes.textColor,
                                        onChange: ( value ) => {
                                            return setAttributes( { textColor: value } );
                                        },
                                        label: __( 'Selected', 'kenzap-blog' ),
                                    },
                                ] }
                        />

                        <PanelColorSettings
                            title={ __( 'Highlight color', 'kenzap-blog' ) }
                            initialOpen={ false }
                            colorSettings={ [
                                    {
                                        value: attributes.mainColor,
                                        onChange: ( value ) => {
                                            return setAttributes( { mainColor: value } );
                                        },
                                        label: __( 'Selected', 'kenzap-blog' ),
                                    },
                                ] }
                        />

                    </PanelBody>

                    <InspectorContainer
                        setAttributes={ setAttributes }
                        { ...attributes }
                        withPadding
                        withWidth100
                        withBackground
                    />
                </InspectorControls>

                <ServerSideRender
                    block="kenzap/blog-01"
                    attributes={ {                  
                        displayType: attributes.displayType,
                        columns: attributes.columns,
                        ignoreNoImage: attributes.ignoreNoImage,
                        ignoreSticky: attributes.ignoreSticky,
                        showCategory: attributes.showCategory,
                        showDate: attributes.showDate,
                        category: attributes.category,
                        per_page: attributes.per_page, 
                        mainColor: attributes.mainColor,  
                        textColor: attributes.textColor,  
                        orderby: attributes.orderby,  
                        pagination: attributes.pagination,  
                        serverSide: true,
                    } }
                />
            </div>
        );
    }
}
