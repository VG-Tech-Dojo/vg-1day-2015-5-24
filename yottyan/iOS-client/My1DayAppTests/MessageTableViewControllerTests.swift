//
//  MessageTableViewControllerTests.swift
//  My1DayApp
//
//  Created by Sei Takayuki on 2015/05/17.
//  Copyright (c) 2015年 VOYAGE GROUP, inc. All rights reserved.
//

import UIKit
import XCTest

class MessageTableViewControllerTests: XCTestCase {

    func testMessageTableViewController() {
        let messageTableViewController: MessageTableViewController = MessageTableViewController()
        
        XCTAssertNil(messageTableViewController.parseJSONObjectToArray(["":""]))
        XCTAssertNil(messageTableViewController.parseJSONObjectToArray([""]))
        XCTAssertNil(messageTableViewController.parseJSONObjectToArray([[]]))
        XCTAssertNotNil(messageTableViewController.parseJSONObjectToArray([["":""]]))
    }


}
