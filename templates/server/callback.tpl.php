<?php
/**
 * @file
 * Template file.
 *
 * @var \EC\Poetry\Services\Plates\Template $this
 * @var string $uri
 */
?><?='<?xml version="1.0" encoding="utf-8"?>'?>
<definitions name="FPFISPoetryIntegration"
             targetNamespace="urn:FPFISPoetryIntegration"
             xmlns:tns="urn:FPFISPoetryIntegration"
             xmlns:xsd="http://www.w3.org/2001/XMLSchema"
             xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
             xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/"
             xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/"
             xmlns="http://schemas.xmlsoap.org/wsdl/">

    <message name="FPFISPoetryIntegrationMessage">
        <part name="user" type="xsd:string" />
        <part name="password" type="xsd:string" />
        <part name="msg" type="xsd:string" />
    </message>

    <message name="FPFISPoetryIntegrationResponse">
        <part name="return" type="xsd:string" />
    </message>

    <portType name="FPFISPoetryIntegrationPort">
        <operation name="EC\Poetry\callback">
            <input message="tns:FPFISPoetryIntegrationMessage" />
            <output message="tns:FPFISPoetryIntegrationResponse" />
        </operation>
    </portType>

    <binding name="FPFISPoetryIntegrationBinding" type="tns:FPFISPoetryIntegrationPort">
        <soap:binding style="rpc" transport="http://schemas.xmlsoap.org/soap/http" />
        <operation name="EC\Poetry\callback">
            <soap:operation soapAction="urn:FPFISPoetryIntegration#EC\Poetry\callback" />
            <input>
                <soap:body use="encoded" namespace="urn:FPFISPoetryIntegration"
                           encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
            </input>
            <output>
                <soap:body use="encoded" namespace="urn:FPFISPoetryIntegration"
                           encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
            </output>
        </operation>
    </binding>

    <service name="FPFISPoetryIntegrationServicio">
        <port name="FPFISPoetryIntegrationPort" binding="tns:FPFISPoetryIntegrationBinding">
            <soap:address location="<?= $uri ?>" />
        </port>
    </service>
</definitions>
