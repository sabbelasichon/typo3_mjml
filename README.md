[![Build Status](https://img.shields.io/travis/sabbelasichon/typo3_mjml/master.svg?style=flat-square)](https://travis-ci.org/sabbelasichon/typo3_mjml)
[![Coverage Status](https://img.shields.io/coveralls/sabbelasichon/typo3_mjml/master.svg?style=flat-square)](https://coveralls.io/github/sabbelasichon/typo3_mjml?branch=master)
[![Downloads](https://img.shields.io/packagist/dt/ssch/typo3-mjml.svg?style=flat-square)](https://packagist.org/packages/ssch/typo3-mjml)

# Use MJML to ease the pain of generating responsive emails

https://mjml.io integration for **TYPO3** with FLUID-Helper.

## Installation

### Over composer:

`composer require ssch/typo3-mjml`

### NPM

Npm is needed for the conversion of the MJML file to HTML

## Usage in Fluid
```html
<html xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers" xmlns:m="http://typo3.org/ns/Ssch/Typo3Mjml/ViewHelpers" data-namespace-typo3-fluid="true">
<m:mjmlToHtml>
    <mjml>
        <mj-body background-color="#F4F4F4" color="#55575d" font-family="Arial, sans-serif">
            <mj-section background-color="#000000" background-repeat="no-repeat" text-align="center" vertical-align="top">
                <mj-column>
                    <mj-image align="center" border="none" padding-bottom="30px" padding="10px 25px" src="{f:uri.image(src: 'image.png')}" target="_blank" title="" width="180px"></mj-image>
                        <mj-text align="left" color="#55575d" font-family="Arial, sans-serif" font-size="13px" line-height="22px" padding-bottom="0px" padding-top="0px" padding="10px 25px">
                            <p style="line-height: 18px; margin: 10px 0; text-align: center;font-size:14px;color:#ffffff;font-family:'Times New Roman',Helvetica,Arial,sans-serif">WOMEN&nbsp; &nbsp; &nbsp; &nbsp;| &nbsp; &nbsp; &nbsp; MEN&nbsp; &nbsp; &nbsp; &nbsp;| &nbsp; &nbsp; &nbsp; KIDS</p>
                         </mj-text>
                </mj-column>
            </mj-section>
        </mj-body>
    </mjml>
</m:mjmlToHtml>
```

### Configuration

You can either use the BinaryRenderer (node is needed) or the APIRenderer (https://mjml.io/api).
This is configured via the Extension Configuration aka ext_conf_template.txt

## MJML Documentation

https://mjml.io/documentation/
