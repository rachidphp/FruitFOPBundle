FruitFOPBundle Class to Data Mapping
====================================

Only fields that are listed will be added to the document

``` yaml
# Bundle/Resources/fruitop/name.yml
Class\ToMap:
    root: root-attribute
    fields:
        property-name: attribute-name
        another-property: attribute
    template:
        file: %kernel.root_dir%/path/to.xsl
